<?php

namespace App\Controller;

use App\Model\AnniversaryDetailsManager;
use App\Model\RateManager;

class AdminAnniversaryDetailController extends AbstractController
{
    public function index(): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }
        $rateManager = new RateManager();
        $anniversaryRates = $rateManager->selectAllAnniversaryRate();

        $detailsManager = new AnniversaryDetailsManager();
        $anniversaryDetails = $detailsManager->selectAll();
        return $this->twig->render('Admin/AnniversaryDetail/index.html.twig', [
            'anniversaryRates' => $anniversaryRates,
            'anniversaryDetails' => $anniversaryDetails,
        ]);
    }

    public function add(int $rate)
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $detailsManager = new AnniversaryDetailsManager();
        $details = $detailsManager->selectAllByRateId($rate);
        if (!empty($details)) {
            $error = '';
            $newDetail = [];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newDetail['detail'] = trim($_POST['detail']);
                $error = $this->validate($newDetail);
                if ($error === '') {
                    $newDetail['rate_id'] = $details[0]['rate_id'];
                    $detailsManager->insert($newDetail);
                    header('Location: /admin/anniversaire');
                }
            }
            return $this->twig->render('Admin/AnniversaryDetail/add.html.twig', [
                'details' => $details,
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
