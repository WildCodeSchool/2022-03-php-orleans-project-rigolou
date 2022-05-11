<?php

namespace App\Controller;

use App\Model\AnniversaryDetailsManager;
use App\Model\RateManager;

class AdminAnniversaryDetailController extends AbstractController
{
    public function index(string $message = ''): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $confirmationMessage = '';
        if ($message === 'deleted') {
            $confirmationMessage = 'Le détail a été supprimé';
        } elseif ($message === 'edited') {
            $confirmationMessage = 'Le détail a été édité';
        }

        $rateManager = new RateManager();
        $anniversaryRates = $rateManager->selectAllAnniversaryRate();

        $detailsManager = new AnniversaryDetailsManager();
        $anniversaryDetails = $detailsManager->selectAll();
        return $this->twig->render('Admin/AnniversaryDetail/index.html.twig', [
            'anniversaryRates' => $anniversaryRates,
            'anniversaryDetails' => $anniversaryDetails,
            'confirmationMessage' => $confirmationMessage,
        ]);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $detailsManager = new AnniversaryDetailsManager();
            $detail = $detailsManager->selectOneById((int) $id);

            if (!empty($detail)) {
                $detailsManager->delete((int)$id);
            }
        }
        header('Location: /admin/anniversaire?message=deleted');
    }

    public function add(int $rate = 0)
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $rateManager = new RateManager();
        $anniversaryRate = $rateManager->selectOneById($rate);
        if (!empty($anniversaryRate)) {
            $error = '';
            $newDetail = [];
            $detailsManager = new AnniversaryDetailsManager();
            $detailsByRate = $detailsManager->selectAllByRateId($rate);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newDetail['detail'] = trim($_POST['detail']);
                $error = $this->validate($newDetail);
                if ($error === '') {
                    $newDetail['rate_id'] = $anniversaryRate['id'];
                    $detailsManager->insert($newDetail);
                    header('Location: /admin/anniversaire/ajouter?rate=' . $newDetail['rate_id']);
                }
            }
            return $this->twig->render('Admin/AnniversaryDetail/add.html.twig', [
                'anniversaryRate' => $anniversaryRate,
                'detailsByRate' => $detailsByRate,
                'detail' => $newDetail,
                'error' => $error,
            ]);
        }
        header('Location: /admin/anniversaire');
    }

    public function edit(int $rate = 0, int $id = 0)
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $detailsManager = new AnniversaryDetailsManager();
        $detailsByRate = $detailsManager->selectAllByRateId($rate);
        $detail = $detailsManager->selectOneById($id);
        if (!empty($detailsByRate) && !empty($detail)) {
            $error = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $detail['detail'] = trim($_POST['detail']);
                $error = $this->validate($detail);
                if ($error === '') {
                    $detailsManager->update($detail);
                    header('Location: /admin/anniversaire?message=edited');
                }
            }
            return $this->twig->render('Admin/AnniversaryDetail/edit.html.twig', [
                'detailsByRate' => $detailsByRate,
                'detail' => $detail,
                'error' => $error,
            ]);
        }
        header('Location: /admin/anniversaire');
    }

    public function validate(array $detail): string
    {
        $error = '';
        $maxDetailLength = 255;
        if (empty($detail['detail'])) {
            $error = 'Le détail est obligatoire';
        } elseif (strlen($detail['detail']) > 255) {
            $error = 'Le détail doit faire moins de ' . $maxDetailLength . 'caractères';
        }
        return $error;
    }
}
