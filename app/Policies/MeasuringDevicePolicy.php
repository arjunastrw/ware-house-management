<?php

namespace App\Policies;

use App\Models\MeasuringDevice;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MeasuringDevicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Adjust the logic based on your requirements
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MeasuringDevice $measuringDevice): bool
    {
        return true; // Adjust the logic based on your requirements
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Adjust the logic based on your requirements
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MeasuringDevice $measuringDevice): bool
    {
        return true; // Adjust the logic based on your requirements
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MeasuringDevice $measuringDevice): bool
    {
        return true; // Adjust the logic based on your requirements
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MeasuringDevice $measuringDevice): bool
    {
        return true; // Adjust the logic based on your requirements
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MeasuringDevice $measuringDevice): bool
    {
        return true; // Adjust the logic based on your requirements
    }
}
