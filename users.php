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
<script>
    $(document).ready(function() {
        // On page load get users from the database
        getUsers();
        // Fetch users from the database
        function getUsers() {
            $.ajax({
                url: "code.php?method=getUsers", // Endpoint
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $("tbody").empty(); // Clear existing rows before appending new ones
                        response.data.forEach(function(user) {
                            $("tbody").append(`
                            <tr>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.phone}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm btn-edit" id="userId" name="userId" value="${user.id}">Edit</button>
                                    <button class="btn btn-danger btn-sm btn-delete" id="userId" name="userId" value="${user.id}">Delete</button>
                                </td>
                            </tr>
                        `);
                        });
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + error);
                    alert("Something went wrong!");
                }
            });
        }

        // Add user form submission request
        $("#addUserForm").submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            $.ajax({
                url: "code.php?method=addUser", // Endpoint
                type: "POST",
                data: $(this).serialize(), // Serialize form data
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        alert("User added successfully!");
                        $("#addUserForm")[0].reset(); // Reset form after submission
                        $("#addUserForm").closest(".modal").modal("hide"); // Hide modal
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + error);
                    alert("Something went wrong!");
                }
            });
        });

        // Edit user request
        $(document).on("click", ".btn-edit", function() {
            let userId = $(this).val(); // Get the user ID from button value
            console.log(userId);
            $.ajax({
                url: "code.php", // Backend script to fetch user
                type: "POST",
                data: {
                    action: "getUser",
                    userId: userId
                },
                dataType: "json",
                success: function(response) {
                    console.log(response.data);
                    if (response.success) {
                        // Populate modal body with fetched user data
                        $("#editUserModal .modal-body").html(`
                            <div class="mb-3">
                                <label for="editName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="${response.data.name}" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="${response.data.email}" required>
                            </div>
                            <div class="mb-3">
                                <label for="editPhone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="${response.data.phone}" required>
                            </div>
                            <input type="hidden" id="userId" name="userId" value="${response.data.id}">
                        `);

                        // Show the modal
                        $("#editUserModal").modal("show");
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + error);
                    alert("Something went wrong!");
                }
            });
        });

        //Update user form submission request
        $("#editUserForm").submit(function(event) {
            console.log('Edit user form submission');
            event.preventDefault(); // Prevent default form submission

            $.ajax({
                url: "code.php?method=updateUser", // Endpoint
                type: "POST",
                data: $(this).serialize(), // Serialize form data
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        alert("User updated successfully!");
                        $("#editUserForm")[0].reset(); // Reset form after submission
                        $("#editUserForm").closest(".modal").modal("hide"); // Hide modal
                        // Reload users
                        getUsers();
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + error);
                    alert("Something went wrong!");
                }
            });
        });

        // Delete user request
        $(document).on("click", ".btn-delete", function() {
            let userId = $(this).val(); // Get the user ID from button value
            console.log(userId);
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    url: "code.php?method=deleteUser", // Endpoint
                    type: "POST",
                    data: {
                        userId: userId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            alert("User deleted successfully!");
                            // Reload users
                            getUsers();
                        } else {
                            alert("Error: " + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + error);
                        alert("Something went wrong!");
                    }
                });
            }
        });
    });
</script>
</body>

</html>