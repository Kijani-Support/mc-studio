<?php 

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Sgcomptech\FilamentTicketing\Interfaces\TicketPolicies;
use Sgcomptech\FilamentTicketing\Models\Ticket;

class TicketPolicy implements TicketPolicies
{
  use HandlesAuthorization;

  public function viewAny(User $user)
  {
    return true;
  }

  public function view(User $user, Ticket $ticket)
  {
    return true;
  }

  public function create(User $user)
  {
    return true;
  }

  public function update(User $user, Ticket $ticket)
  {
    return $user->can('manage all tickets')
      || $user->can('assign tickets')
      || ($user->can('manage assigned tickets') && $ticket->assigned_to_id == $user->id)
      || $ticket->user_id == $user->id;
  }

  public function delete(User $user, Ticket $ticket)
  {
    return $user->can('delete tickets');
  }

  public function manageAllTickets($user): bool
  {
    return $user->can('manage all tickets');
  }

  public function manageAssignedTickets($user): bool
  {
    return $user->can('manage assigned tickets');
  }

  public function assignTickets($user): bool
  {
    return $user->can('assign tickets');
  }
}