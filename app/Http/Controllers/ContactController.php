<?php

namespace App\Http\Controllers;

use App\Actions\Contacts\CreateContactAndSendToCRMAction;
use App\Actions\Contacts\DeleteContactAndSendToCRMAction;
use App\Actions\Contacts\UpdateContactAndEditInCRMAction;
use App\DTOs\StoreContactDTO;
use App\DTOs\UpdateContactDTO;
use App\Http\Requests\Contacts\StoreContactRequest;
use App\Http\Requests\Contacts\UpdateContactRequest;
use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ContactRepository $repository): View
    {
        try {

            $contacts = $repository->listAndFilter(
                page: $request->query('page', 1),
                perPage: $request->query('per_page', 10),
                filter: $request->query('filter'),
            );

            $header = __('Contacts');

            return view('dashboard.contacts.index', compact('contacts', 'header'));
        } catch (\Throwable $throwable) {
            Log::error('Error fetching contacts: ' . $throwable->getMessage(), [
                'stack_trace' => $throwable->getTraceAsString(),
            ]);

            abort(Response::HTTP_INTERNAL_SERVER_ERROR, __('An error occurred while fetching contacts.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $header = __('Create Contact');

        return view('dashboard.contacts.create', compact('header'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request, CreateContactAndSendToCRMAction $action): RedirectResponse
    {
        try {

            $action->handle(new StoreContactDTO($request->all()));

            return redirect()->route('dashboard.contacts.index')->with('success', __('Contact created successfully!'));
        } catch (ValidationException $validationException) {
            return redirect()->back()
                ->withErrors($validationException->errors())
                ->withInput();
        } catch (\Throwable $throwable) {
            Log::error('Error creating contact: ' . $throwable->getMessage(), [
                'stack_trace' => $throwable->getTraceAsString(),
            ]);

            abort(Response::HTTP_INTERNAL_SERVER_ERROR, __('An error occurred while creating the contact.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact): View
    {
        $header = __('View Contact' . $contact->name);

        return view('dashboard.contacts.show', compact('header', 'contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact): View
    {
        $header = __('Edit Contact: ' . $contact->name);

        return view('dashboard.contacts.edit', compact('header', 'contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact, UpdateContactAndEditInCRMAction $action): RedirectResponse
    {
        try {

            $action->handle(new UpdateContactDTO($request->merge(['id' => $contact->id])->toArray()));

            return redirect()->route('dashboard.contacts.index')->with('status', __('Contact updated successfully!'));

        } catch (ValidationException $validationException) {
            return redirect()->back()
                ->withErrors($validationException->errors())
                ->withInput();
        } catch (ModelNotFoundException $throwable) {
            abort(Response::HTTP_NOT_FOUND, __('Contact not found.'));
        } catch (\Throwable $throwable) {
            Log::error('Error updating contact: ' . $throwable->getMessage(), [
                'contact_id' => $contact->id,
                'stack_trace' => $throwable->getTraceAsString(),
            ]);

            abort(Response::HTTP_INTERNAL_SERVER_ERROR, __('An error occurred while updating the contact.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact, DeleteContactAndSendToCRMAction $action): RedirectResponse
    {
        try {

            $action->handle($contact->id);

            return redirect()->route('dashboard.contacts.index')->with('success', __('Contact deleted successfully!'));

        } catch (ModelNotFoundException $throwable) {
            abort(Response::HTTP_NOT_FOUND, __('Contact not found.'));
        } catch (\Throwable $throwable) {
            Log::error('Error deleting contact: ' . $throwable->getMessage(), [
                'contact_id' => $contact->id,
                'stack_trace' => $throwable->getTraceAsString(),
            ]);
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, __('An error occurred while deleting the contact.'));
        }
    }
}
