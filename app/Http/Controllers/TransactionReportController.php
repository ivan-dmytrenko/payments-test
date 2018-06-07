<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserWalletRepositoryInterface;
use App\Repositories\UserWalletRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DateTime;

class TransactionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserWalletRepositoryInterface $userWallet
     * @return \Illuminate\Http\Response
     */
    public function index(UserWalletRepositoryInterface $userWallet)
    {
        $errors = [];
        $viewData = [];

        $data = request()->validate([
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date',
            'username' => 'nullable',
        ]);

        if (isset($data['period_start']) && isset($data['period_end'])) {
            $startDate = new DateTime($data['period_start']);
            $endDate = new DateTime($data['period_end']);

            if ($startDate > $endDate) {
                $errors['date'] = 'Date start cannot be a date after end date.';
            }
        }

        $datePeriodStart = request('period_start');
        $datePeriodEnd = request('period_end');

        try {
            $username = $data['username'] ?? '';

            if (!$errors) {
                $viewData['user'] = $userWallet->getUserWalletWithTransactionsInfo($username, $datePeriodStart, $datePeriodEnd);
            }
        } catch (ModelNotFoundException $e) {
            $errors['user'] = 'Cannot find user.';
        }

        return view('transaction_report', $viewData)->withErrors($errors);
    }

    public function exportCsvReport(UserWalletRepository $userWallet)
    {
        $username = request('username');

        if ($username) {
            $dateStart = request('period_start');
            $dateEnd = request('period_end');
            $user = $userWallet->getUserWalletWithTransactionsInfo($username, $dateStart, $dateEnd);

            $viewData = [
                'user' => $user,
                'period_start' => $dateStart,
                'period_end' => $dateEnd,
            ];

            $filename = 'transactions_' . date('Y-d-m');

            return response()
                ->view('transaction_xml_report', $viewData, 200)
                ->header('Cache-Control', 'public')
                ->header('Content-Description', 'File Transfer')
                ->header('Content-Disposition', "attachment; filename=$filename.xml")
                ->header('Content-Transfer-Encoding', 'binary')
                ->header('Content-Type', 'text/xml');
        }
    }
}
