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

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            if ($id > 0) {
                $detailsManager = new AnniversaryDetailsManager();
                $detail = $detailsManager->selectOneById((int) $id);

                if (!empty($detail)) {
                    $detailsManager->delete((int)$id);
                }
            }
        }
        header('Location: /admin/anniversaire');
    }
}
