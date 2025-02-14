<?php
// Include all popups modals
include('popups.html');
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
        <h1 class="m-0">Users</h1>
        <button class="btn btn-primary" id="addUserBtn" data-toggle="modal" data-target="#addUserModal">Add User</button>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic rows will be added here -->
        </tbody>
    </table>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- AJAX -->
<script src="app.js"></script>
</body>

</html>