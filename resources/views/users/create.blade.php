
<div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Add Inspector</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username" style="color: black">Username:</label>
                            <input class="form-control form-control-sm" name="username" type="text"
                                placeholder="input the username.." required>
                        </div>
                        <div class="form-group">
                            <label for="nik" style="color: black">NIK:</label>
                            <input class="form-control form-control-sm" name="nik" type="text"
                                placeholder="input the NIK.." required>
                        </div>
                        <div class="form-group">
                            <label for="name" style="color: black">Name:</label>
                            <input class="form-control form-control-sm" name="name" type="text"
                                placeholder="input the name.." required>
                        </div>

                        <div class="form-group">
                            <label for="roles" style="color: black">Role:</label>
                            <select class="form-control form-control-sm" name="roles" required>
                                <option value="" selected disabled>Select a role</option>
                                @foreach (\App\Models\User::getPossibleRoles() as $role)
                                    <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password" style="color: black">Password:</label>
                            <input class="form-control form-control-sm" name="password" type="password"
                                placeholder="input password .." required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" style="color: black">Confirm Password:</label>
                            <input class="form-control form-control-sm" name="password_confirmation" type="password"
                                placeholder="confirm the password .." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="level" value="admin">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: black; font-weight: bold">Back</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #1a7fcd; font-weight: bold">Add Inspector</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
