<?php
    require_once 'connection.php';
    require_once 'function.php';

if(isset($_POST['addclient'])){
    $id = $_POST['id'];
    $name = $_POST['client_name'];
    $email = $_POST['email'];
    $pwd = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $group = $_POST['group'];
    /*echo $id;
    echo $name;
    echo $email;
    echo $pwd;
    echo $phone;
    echo $group;
    echo $address;*/
    if(clientExists($connection, $email) !== false){
        header("location: ../adding.php?add=client&status=emailtaken");
        exit();
    }
    addClient($connection, $id, $name, $email, $pwd, $phone, $address, $group);
}elseif(isset($_POST['removeclient'])){
    $id = $_POST['removeclient'];
    /*echo $id;
    echo $name;
    echo $email;
    echo $pwd;
    echo $phone;
    echo $group;
    echo $address;*/
    deleteClient($connection, $id);
}elseif(isset($_POST['updateclient'])){
    $id = $_POST['updateclient'];
    $name = $_POST['client_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $group = $_POST['group'];
    /*echo $id;
    echo $name;
    echo $email;
    echo $phone;
    echo $group;
    echo $address;*/
    updateClient($connection, $id, $name, $email, $phone, $address, $group);
}elseif(isset($_POST['addproject'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $progress = $_POST['progress'];
    $priority = $_POST['priority'];
    $client = $_POST['client'];
    $budget = $_POST['budget'];
    $start_date = $_POST['start_date'];
    $due_date = $_POST['due_date'];
    $assign = $_POST['assign'];
    $group = $_POST['group'];
    $note = $_POST['note'];
    $status = $_POST['status'];
    $data = fetchClientName($connection, $client);
    $client_id = $data['client_id'];
    /*echo $id;
    echo $title;
    echo $progress;
    echo $priority;
    echo $client;
    echo $budget;
    echo $start_date;
    echo $due_date;
    echo $assign;
    echo $group;
    echo $note;
    echo $status;*/
    addProject($connection, $id, $title, $progress, $priority, $client, $budget, $start_date, $due_date, $assign, $group, $note, $status, $client_id);
}elseif(isset($_POST['updateProject'])){
    $id = $_POST['updateProject'];
    $title = $_POST['title'];
    $progress = $_POST['progress'];
    $priority = $_POST['priority'];
    $client = $_POST['client'];
    $budget = $_POST['budget'];
    $start_date = $_POST['start_date'];
    $due_date = $_POST['due_date'];
    $assign = $_POST['assign'];
    $group = $_POST['group'];
    $note = $_POST['note'];
    $status = $_POST['status'];
    /*echo $id;
    echo $title;
    echo $progress;
    echo $priority;
    echo $client;
    echo $budget;
    echo $start_date;
    echo $due_date;
    echo $assign;
    echo $group;
    echo $note;
    echo $status;*/
    updateProject($connection, $title, $progress, $priority, $client, $budget, $start_date, $due_date, $assign, $group, $note, $status, $id );
}
