<?php

class AllRolesDataSource implements IRolesDataSource
{
    /**
     * @return array UserRoles
     */
    public static function roles(){
        return array(
            UserRoles::DIRECTOR,
            UserRoles::SUPER_ADMIN,
            UserRoles::AUDITOR,
            UserRoles::ADMIN,
            UserRoles::ACCOUNTANT,
            UserRoles::AUTHOR,
            UserRoles::CONTENT_MANAGER,
            UserRoles::TEACHER_CONSULTANT,
            UserRoles::TRAINER,
            UserRoles::STUDENT,
            UserRoles::TENANT,
            UserRoles::SUPERVISOR,
        );
    }

    public static function localRoles(){
        return array(
            UserRoles::ADMIN,
            UserRoles::ACCOUNTANT,
            UserRoles::AUTHOR,
            UserRoles::CONTENT_MANAGER,
            UserRoles::TEACHER_CONSULTANT,
            UserRoles::TRAINER,
            UserRoles::TENANT,
            UserRoles::SUPERVISOR,
        );
    }

    public static function teacherRoles(){
        return array(
            UserRoles::ACCOUNTANT,
            UserRoles::AUTHOR,
            UserRoles::CONTENT_MANAGER,
            UserRoles::TEACHER_CONSULTANT,
            UserRoles::TRAINER,
            UserRoles::TENANT,
            UserRoles::SUPERVISOR,
        );
    }
}