<?php

namespace App\Http\Controllers;

use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function index(Request $request, ContactRepository $repository): View
    {
        try {

            $contacts = $repository->listAndFilter(
                page: $request->query('page', 1),
                perPage: $request->query('per_page', 10),
            );

            $header = __('Contacts');

            return view('index', compact('contacts', 'header'));

        } catch (\Throwable $throwable) {
            Log::error('Error fetching contacts: ' . $throwable->getMessage(), [
                'stack_trace' => $throwable->getTraceAsString(),
            ]);

            abort(Response::HTTP_INTERNAL_SERVER_ERROR, __('An error occurred while fetching contacts.'));
        }
    }
}
