<?php
require_once 'dbconfig.php'; // Include database connection

header('Content-Type: application/json');

// Get all users from the database
if (isset($_GET['method']) && $_GET['method'] == 'getUsers') {
    try {
        // Fetch users from the database
        $users = ORM::for_table('users')->find_array();
        echo json_encode(["success" => true, "data" => $users]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

// Add a new user to the database
if (isset($_GET['method']) && $_GET['method'] == 'addUser' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    try {
        // Insert user into the database
        $user = ORM::for_table('users')->create();
        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->save();

        echo json_encode(["success" => true, "message" => "User added successfully."]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

// Get user details by ID
if (isset($_POST['action']) && $_POST['action'] == 'getUser' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'] ?? '';

    if (empty($userId)) {
        echo json_encode(["success" => false, "message" => "User ID is required."]);
        exit;
    }

    try {
        $user = ORM::for_table('users')->find_one($userId);
        if ($user) {
            echo json_encode([
                "success" => true,
                "data" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "phone" => $user->phone
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "User not found."]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

// Update a new user to the database
if (isset($_GET['method']) && $_GET['method'] == 'updateUser' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if (empty($userId)) {
        echo json_encode(["success" => false, "message" => "User ID is required."]);
        exit;
    }

    try {
        //Find user by ID
        $user = ORM::for_table('users')->find_one($id);
        if ($user) {
            $user->name = $name;
            $user->email = $email;
            $user->phone = $phone;
            $user->save();

            echo json_encode(["success" => true, "message" => "User updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "User not found."]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

// Delete a user from the database
if (isset($_GET['method']) && $_GET['method'] == 'deleteUser' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'] ?? '';

    if (empty($userId)) {
        echo json_encode(["success" => false, "message" => "User ID is required."]);
        exit;
    }

    try {
        //Find user by ID
        $user = ORM::for_table('users')->find_one($userId);
        if ($user) {
            $user->delete();

            echo json_encode(["success" => true, "message" => "User deleted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "User not found."]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}