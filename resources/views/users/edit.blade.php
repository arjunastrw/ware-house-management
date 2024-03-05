@foreach ($users as $user)
    <div class="modal fade" id="editUser{{ $user->id }}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Edit Inspector</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="username" style="color: black">Username:</label>
                                <input class="form-control form-control-sm" name="username" type="text"
                                       placeholder="input the username.." value="{{ $user->username }}" required>
                            </div>
                            <div class="form-group">
                                <label for="nik" style="color: black">NIK:</label>
                                <input class="form-control form-control-sm" name="nik" type="number" placeholder="Input the NIK.." value="{{ $user->nik }}" required maxlength="6">
                            </div>
                            <div class="form-group">
                                <label for="name" style="color: black">Name:</label>
                                <input class="form-control form-control-sm" name="name" type="text"
                                       placeholder="input the name.." value="{{ $user->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="roles" style="color: black">Role:</label>
                                <select class="form-control form-control-sm" name="roles" required>
                                    <option value="" disabled>Select a role</option>
                                    @foreach (\App\Models\User::getPossibleRoles() as $role)
                                        <option value="{{ $role }}"
                                            {{ $user->roles === $role ? 'selected' : '' }}>
                                            {{ ucfirst($role) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" id="passwordFields{{ $user->id }}" style="display: block;">
                                <label for="newPassword" style="color: black">New Password:</label>
                                <div class="input-group">
                                    <input class="form-control form-control-sm" name="newPassword" type="password"
                                           placeholder="input new password ..">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-eye" id="toggleNewPassword{{ $user->id }}"
                                               onclick="togglePasswordVisibility('newPassword{{ $user->id }}')"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" id="confirmPasswordFields{{ $user->id }}"
                                 style="display: block;">
                                <label for="confirmNewPassword" style="color: black">Confirm Password:</label>
                                <div class="input-group">
                                    <input class="form-control form-control-sm" name="confirmNewPassword"
                                           type="password" placeholder="confirm the new password ..">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-eye" id="toggleConfirmNewPassword{{ $user->id }}"
                                               onclick="togglePasswordVisibility('confirmNewPassword{{ $user->id }}')"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="level" value="{{ $user->level }}">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-weight: bold; background-color: black; margin-right: 5px;">Cancel</button>
                            <button type="submit" class="btn btn-primary" style="font-weight: bold; background-color: #268bd9;">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    function togglePasswordVisibility(inputFieldId) {
        var inputField = document.getElementById(inputFieldId);
        var type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';

        inputField.setAttribute('type', type);
    }

    @foreach ($users as $user)
    document.getElementById('toggleNewPassword{{ $user->id }}').addEventListener('click', function() {
        togglePasswordVisibility('newPassword{{ $user->id }}');
    });

    document.getElementById('toggleConfirmNewPassword{{ $user->id }}').addEventListener('click', function() {
        togglePasswordVisibility('confirmNewPassword{{ $user->id }}');
    });
    @endforeach
</script>
