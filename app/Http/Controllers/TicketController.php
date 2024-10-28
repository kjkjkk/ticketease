<?php

namespace App\Http\Controllers;

use App\Enum\AuditActivity;
use App\Enum\Notification;
use App\Events\Logs\TicketStatusUpdateEvent;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Requests\TicketUpdateRequest;
use App\Mail\CompleteTicket;
use App\Models\TicketComplete;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

//----------------changesssss-------------
use App\Events\Admin\NotifyAdminNewTicket;
use App\Events\Logs\CloseTicketEvent;
use App\Events\Logs\ForWasteTicketEvent;
use App\Events\Logs\InvalidTicketEvent;
use App\Events\NotifyRequestorStatusUpdate;
use App\Mail\ForWasteTicket;

//----------------changesssss-------------


class TicketController extends Controller
{

    public function store(TicketStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        // Check for pending tickets
        list($hasPendingTicket, $status_id, $message) = $request->checkRequestorTickets($validated['requestor_id'], $validated['ticket_nature_id']);
        if ($hasPendingTicket) {
            Alert::warning('Submission Failed', $message);
            return redirect()->back();
        }
        // Proceed to create a new ticket if no pending ticket with the same nature is found
        $ticket = Ticket::create($validated);

        event(new NotifyAdminNewTicket($ticket));

        Alert::success('Ticket Submitted', 'Ticket submission is successful');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // $ticket = Ticket::findOrFail($id);
        // return view('pages.requestor.home', ['ticket' => $ticket]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketUpdateRequest $request)
    {
        try {
            $validated = $request->validated();
            $ticket = Ticket::findOrFail($validated['id']);
            $ticket->update([
                'ticket_nature_id' => $validated['ticket_nature_id'],
                'district_id' => $validated['district_id'],
                'department' => $validated['department'],
                'device_id' => $validated['device_id'],
                'brand' => $validated['brand'],
                'model' => $validated['model'],
                'property_no' => $validated['property_no'],
                'serial_no' => $validated['serial_no'],
                'details' => $validated['details'],
            ]);
            Alert::success('Ticket Update', 'You updated the ticket successfully');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Alert::success('Ticket Update Error', $e);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(string $id)
    {
        //
    }

    public function closeTicket(Request $request)
    {
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($request->ticket_id);
            // Status 10 = Closed
            $ticket->status_id = 10;
            $ticket->save();

            event(new CloseTicketEvent($ticket));
            event(new NotifyRequestorStatusUpdate($ticket));
            event(new TicketStatusUpdateEvent($ticket, AuditActivity::CLOSED->id(), AuditActivity::CLOSED->activity()));

            DB::commit();
            Alert::success("Closed Ticket", "You successfuly closed the ticket.");
            return redirect()->route('shared.my-tickets');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }

    public function forWaste(Request $request)
    {
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($request->ticket_id);
            $ticket->status_id = AuditActivity::FOR_WASTE->id();
            $ticket->save();

            // event(new ForWasteTicketEvent($ticket));
            Mail::to($ticket->requestor->email)->send(new ForWasteTicket($ticket));
            event(new NotifyRequestorStatusUpdate($ticket));
            event(new TicketStatusUpdateEvent($ticket, AuditActivity::FOR_WASTE->id(), AuditActivity::FOR_WASTE->activity()));
            DB::commit();
            Alert::success("For Waste Ticket", "You successfuly updated the ticket to for waste.");
            return redirect()->route('shared.my-tickets');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }

    public function toCitc(Request $request)
    {
        try {
            $ticket = Ticket::find($request->ticket_id);
            event(new TicketStatusUpdateEvent($ticket, AuditActivity::TO_CITC->id(), AuditActivity::TO_CITC->activity()));
            $ticket->status_id = AuditActivity::TO_CITC->id();
            $ticket->save();
            event(new NotifyRequestorStatusUpdate($ticket));
            Alert::success("To CITC Ticket", "You successfuly updated the ticket to To CITC.");
            return redirect()->route('shared.my-tickets');
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }

    public function invalid(Request $request)
    {
        try {
            DB::beginTransaction();

            // Update ticket and save
            $ticket = Ticket::find($request->ticket_id);
            $ticket->status_id = 9;
            $ticket->save();

            // Fire events
            event(new NotifyRequestorStatusUpdate($ticket));
            event(new InvalidTicketEvent($ticket, $request->invalidReason));
            event(new TicketStatusUpdateEvent($ticket, AuditActivity::INVALID->id(), AuditActivity::INVALID->activity()));

            // Commit transaction
            DB::commit();

            // Return success
            Alert::success("Ticket Invalidate", "You successfully invalidated the ticket.");
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Something went wrong, please try again');
            return redirect()->back();
        }
    }
}
