<?php

try{
    $pdo = new PDO ('mysql:host=localhost', 'projet_studi', '040904Ad@nledj1');

    $pdo->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);

    if($pdo->exec('CREATE DATABASE restaurant_server') !== false){

        $serveur = new PDO ('mysql:dbname=restaurant_server;host=localhost', 'projet_studi', '040904Ad@nledj1');

        if($serveur->exec('CREATE TABLE administrator(
            admin_id INT not null PRIMARY KEY AUTO_INCREMENT,
            admin_email text not null,
            admin_password text not null
        )') !==false){
            if($serveur->exec('CREATE TABLE users(
                user_id INT not null PRIMARY KEY AUTO_INCREMENT,
                user_email text not null,
                user_password text not null,
                user_phone INT not null,
                user_gender BOOL not null
                adminId INT not null,
                FOREIGN KEY (adminId) REFERENCES admin (admin_id)
            )') !== false){
                if($serveur->exec('CREATE TABLE reservation(
                    reservation_id INT not null PRIMARY KEY AUTO_INCREMENT,
                    reservation_time time not null,
                    numberOfPeople INT not null,
                    userId INT not null,
                    FOREIGN KEY (userId) REFERENCES users (user_id)
                )') !== false){
                    if($serveur->exec('CREATE TABLE allergies(
                        allergies_id INT not null PRIMARY KEY AUTO_INCREMENT,
                        allergies_list text not null,
                        reservationId INT not null,
                        FOREIGN KEY (reservationId) REFERENCES reservation (reservation_Id)
                    )') !== false){
                        if($serveur->exec('CREATE TABLE restaurant(
                            restaurant_id INT not null PRIMARY KEY AUTO_INCREMENT,
                            maxCapacity INT not null,
                            stockReservation INT not null,
                            reservationId INT not null,
                            FOREIGN KEY (reservationId) REFERENCES reservation (reservation_Id)
                        )') !== false){
                            if($serveur->exec('CREATE TABLE meals(
                                meals_id INT not null PRIMARY KEY AUTO_INCREMENT,
                                meals_title varchar not null,
                                meals_description varchar not null,
                                meals_price DOUBLE not null,
                                user_gender BOOLEAN not null,
                                restaurantId INT not null,
                                FOREIGN KEY (restaurantId) REFERENCES restaurant (restaurant_Id))
                            )') !== false){
                                if($serveur->exec('CREATE TABLE mealsPhoto(
                                    mealsPhoto_id INT not null PRIMARY KEY AUTO_INCREMENT,
                                    mealsPhoto_title VARCHAR not null,
                                    mealsPhoto_image BLOB not null,
                                    mealsId INT not null,
                                    FOREIGN KEY (mealsId) REFERENCES meals (meals_Id)
                                )') !== false){
                                     if($serveur->exec('CREATE TABLE mealsCategory(
                                        mealsCategory_id INT not null PRIMARY KEY AUTO_INCREMENT,
                                        mealsCategory_name VARCHAR not null,
                                        mealsId INT not null,
                                        FOREIGN KEY (mealsId) REFERENCES meals (meals_Id)
                                    )') !== false){
                                        if($serveur->exec('CREATE TABLE menu(
                                            menu_id INT not null PRIMARY KEY AUTO_INCREMENT,
                                            menu_title VARCHAR not null,
                                            menu_price DOUBLE not null,
                                            mealsId INT not null,
                                            FOREIGN KEY (mealsId) REFERENCES meals (meals_Id)
                                        )') !== false){
                                            if($serveur->exec('CREATE TABLE formula(
                                                formula_id INT not null PRIMARY KEY AUTO_INCREMENT,
                                                fromula_name VARCHAR not null,
                                                formula_price DOUBLE not null,
                                                formula_description text not null,
                                                menuId INT not null,
                                                FOREIGN KEY (menuId) REFERENCES menu (menu_Id)
                                            )') !== false){
                                                echo "Installation BDD réussie";
                                            }else{
                                                echo "Impossible de créer table formula";}                                        }
                                        }else {echo "Impossible de créer table menu";}
                                        }else{ echo "Impossible de créer table meals";}
                                }else{echo "Impossible de créer table mealsCategory";}
                            }else{echo "Impossible de créer table mealsPhoto";}
                        }else{ echo "Impossible de créer table meals"; }
                    }else{echo "Impossible de créer table restaurant";}
                }else{
                    echo "Impossible de créer table allergies";}
            }else{echo "Impossible de créer table reservation";}
        }else{echo "Impossible de créer table users";}
    }catch(PDOException $err){
    $err->getMessage();
}