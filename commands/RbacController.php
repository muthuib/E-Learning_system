<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        
        // CREATE PERMISSIONS
        //  (check if the permission already exist)
        $createPost = $auth->getPermission('createPost');
        if ($createPost === null) {
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);
        }

        //  (check if the permission already exist)
        $updatePost = $auth->getPermission('updatePost');
        if ($updatePost === null) {
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update a post';
        $auth->add($updatePost);
        }

        //adding other permissions
        //  (check if the permission already exist)
        $viewPost = $auth->getPermission('viewPost');
        if ($viewPost === null) {
            $viewPost = $auth->createPermission('viewPost');
            $viewPost->description = 'view a post';
            $auth->add($viewPost);
        }

        //  (check if the permission already exist)
        $deletePost = $auth->getPermission('deletePost');
        if ($deletePost === null) {
            $deletePost = $auth->createPermission('deletePost');
            $deletePost->description = 'delete a post';
            $auth->add($deletePost);
        }

        // permission to hide unauthorised user/roles from seeing manage users in sidebar
        //  (check if the permission already exist)
        $manageUsers = $auth->getPermission('manageUsers');
        if ($manageUsers === null) {
            $manageUsers = $auth->createPermission('manageUsers');
            $manageUsers->description = 'manage Users';
            $auth->add($manageUsers);
        }

        // permission to hide unauthorised user/roles from seeing manage users roles and permissions in sidebar
        //  (check if the permission already exist)
        $manageUsersPermission = $auth->getPermission('manageUsersPermission');
        if ($manageUsersPermission === null) {
            $manageUsersPermission = $auth->createPermission('manageUsersPermission');
            $manageUsers->description = 'manage Users Permission';
            $auth->add($manageUsersPermission);
        }

        // CREATE ROLES AND ASSIGN ROLES
        //check if the role exists
        $admin = $auth->getRole('admin');
        if ($admin === null) {
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        }
        // Assign permissions only if they haven't been assigned yet
        if (!$auth->hasChild($admin, $createPost)) {
            $auth->addChild($admin, $createPost);
        }
        if (!$auth->hasChild($admin, $updatePost)) {
            $auth->addChild($admin, $updatePost);
        }
        if (!$auth->hasChild($admin, $deletePost)) {
            $auth->addChild($admin, $deletePost);
        }
        if (!$auth->hasChild($admin, $viewPost)) {
            $auth->addChild($admin, $viewPost);
        }
        //assign admin role a permission to manage users
        if (!$auth->hasChild($admin, $manageUsers)) {
            $auth->addChild($admin, $manageUsers);
        }

        //assign admin role a permission to manage users roles and permissions
        if (!$auth->hasChild($admin, $manageUsersPermission)) {
            $auth->addChild($admin, $manageUsersPermission);
        }


        //check if the role exists
        $instructor = $auth->getRole('instructor');
        if ($instructor === null) {
        $instructor = $auth->createRole('instructor');
        $auth->add($instructor);
        }
        if (!$auth->hasChild($instructor, $createPost)) {
            $auth->addChild($instructor, $createPost);
        }
        if (!$auth->hasChild($instructor, $updatePost)) {
            $auth->addChild($instructor, $updatePost);
        }
        if (!$auth->hasChild($instructor, $deletePost)) {
            $auth->addChild($instructor, $deletePost);
        }
        if (!$auth->hasChild($instructor, $viewPost)) {
            $auth->addChild($instructor, $viewPost);
        }

        //check if the role exists
        $student = $auth->getRole('student');
        if ($student === null) { 
        $student = $auth->createRole('student');
        $auth->add($student);
        }
        // Assign permissions based on your desired permissions for the student role
        if (!$auth->hasChild($student, $createPost)) {
            $auth->addChild($student, $createPost);
        }
        if (!$auth->hasChild($student, $updatePost)) {
            $auth->addChild($student, $updatePost);
        }
        if (!$auth->hasChild($student, $deletePost)) {
            $auth->addChild($student, $deletePost);
        }
        if (!$auth->hasChild($student, $viewPost)) {
            $auth->addChild($student, $viewPost);
        }

        echo "RBAC roles and permissions have been initialized.\n";
    }
    public function actionAssign()
    {
        $auth = Yii::$app->authManager;

        // Assign role to user
        $auth->assign($auth->getRole('admin'), 1); // Assign admin role to user with ID 1
        $auth->assign($auth->getRole('instructor'), 2); // Assign instructor role to user with ID 2
        $auth->assign($auth->getRole('student'), 3); // Assign instructor role to user with ID 3


        echo "Roles have been assigned to users.\n";
    }

}