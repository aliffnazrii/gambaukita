@extends('layout.owner')

@section('title', 'Admin Profile Page')

@section('style')
    <style>
        .profile-img {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-img img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Profile Image and Information -->
        <div class="card mb-3 p-3">
            <h3>Personal Information</h3>
            <div class="profile-img text-center m-3">
                <img src="https://via.placeholder.com/150" alt="Admin Profile Picture" style="border-radius: 100%">
            </div>
            <form>
                <div class="form-group">
                    <label for="adminName">Full Name</label>
                    <input type="text" id="adminName" class="form-control" value="John Doe" readonly>
                </div>
                <div class="form-group">
                    <label for="adminEmail">Email Address</label>
                    <input type="email" id="adminEmail" class="form-control" value="admin@example.com" readonly>
                </div>
                <div class="form-group">
                    <label for="adminPhone">Phone Number</label>
                    <input type="tel" id="adminPhone" class="form-control" value="+1234567890" readonly>
                </div>
                <div class="form-group">
                    <label for="adminAddress">Address</label>
                    <textarea id="adminAddress" class="form-control" readonly>123 Admin Street, Admin City, Admin Country</textarea>
                </div>
            </form>
        </div>

        <!-- Job Information -->
        <div class="card mb-3 p-3">
            <h3>Job Information</h3>
            <form>
                <div class="form-group">
                    <label for="adminRole">Role</label>
                    <input type="text" id="adminRole" class="form-control" value="Administrator" readonly>
                </div>
                <div class="form-group">
                    <label for="adminDepartment">Department</label>
                    <input type="text" id="adminDepartment" class="form-control" value="IT" readonly>
                </div>
                <div class="form-group">
                    <label for="adminStartDate">Employment Start Date</label>
                    <input type="date" id="adminStartDate" class="form-control" value="2018-01-15" readonly>
                </div>
                <div class="form-group">
                    <label for="adminStatus">Work Status</label>
                    <select id="adminStatus" class="form-control" disabled>
                        <option value="active" selected>Active</option>
                        <option value="on-leave">On Leave</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Account Settings -->
        <div class="card mb-5 p-3">
            <h3>Account Settings</h3>
            <form>
                <div class="form-group">
                    <label for="changePassword">Change Password</label>
                    <input type="password" id="changePassword" class="form-control" placeholder="Enter new password">
                </div>
                <div class="form-group">
                    <label for="changeEmail">Change Email</label>
                    <input type="email" id="changeEmail" class="form-control" placeholder="Enter new email address">
                </div>
                <div class="form-group">
                    <label for="notifications">Notifications</label>
                    <select id="notifications" class="form-control">
                        <option value="enabled" selected>Enabled</option>
                        <option value="disabled">Disabled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Update Settings</button>
            </form>
        </div>
    </div>
@endsection
