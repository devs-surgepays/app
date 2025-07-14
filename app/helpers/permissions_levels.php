<?php


/**
 * Funcion que retorna parta del where para mostrar los empleados que trabajan el día actual.
 * Toma "permissionLevelId" de la session para consultar con "&" que tipo de permiso contiene.
 * Si contiene permissionLevelId 2 es Regular Agente
 * Si contiene permissionLevelId 4 es Supervisor
 * Si contiene permissionLevelId 8 es Account Manager
 * Pero si contiene mas de un permissionLevelId la query se concatena mostrando los empleados.
 *
 * Ejemplo: permissionLevelId = 4 Retorna: and ( em.superiorId = 7 or em.employeeId = 8 ) 
 * Ejemplo: permissionLevelId = 8 Retorna: and ( em.areaId = 10 )
 * 
 * Sin query  $where = ''; muestra todos los empleados sin restricciones (sin where)
 * @return string
 */
function getPLEmployeeTable($withWhere, $tableAps = false)
{
    $where = 'or em.superiorId = ' . $_SESSION['userId'] . ' or em.employeeId = ' . $_SESSION['employeeId'];

    $permissionLevelId = $_SESSION['permissionLevelId'];
    // if (($permissionLevelId & 2))  $where .= ' or em.employeeId = ' . $_SESSION['employeeId']; // Regular Agent
    //if (($permissionLevelId & 4))  $where .= ' or em.superiorId = ' . $_SESSION['userId'] . ' or em.employeeId = ' . $_SESSION['employeeId']; // Supervisor
    if (($permissionLevelId) & 8 and $tableAps)  $where =    ' ( (em.employeeId != '.$_SESSION['employeeId'].' and ( aprovedByM>=0 )) or (em.employeeId = '.$_SESSION['employeeId'].' and ( aprovedByM = 1  )) ) and em.areaId = '.$_SESSION['areaId'];  //' or em.areaId = ' . $_SESSION['areaId']; // Account Manager
    if (($permissionLevelId) & 8 and !$tableAps )  $where .= ' or em.areaId = ' . $_SESSION['areaId']; // Account Manager
    if (($permissionLevelId & 16))  $where = ''; // HR
    if (($permissionLevelId & 32))  $where = ' or em.areaId in (5,10,12,13,15) '; // Operation Manager  - 5 OPERACIONES GLOBALES - 10 MERCHANTS - 12 CUMPLIMIENTO DEL PRODUCTO - 13 CALIDAD - 15 SURGEPHONE
    if (($permissionLevelId & 64))  $where = ''; // Super Admin
    if (($permissionLevelId & 128))  $where = ''; // Development
    if (($permissionLevelId & 256))  $where = ''; // External person
    if (($permissionLevelId & 512))  $where = ''; // WF
    if (($permissionLevelId & 1024))  $where = '';
    if (!empty($where)) {
        //Delete the first "OR"
        $where = trim($where);
        $modifiedString = preg_replace('/^or\s+/', '', $where);

        if ($withWhere)  $where = ' where ( ' . $modifiedString . ' )';
        else  $where = ' and ( ' . $modifiedString . ' )';
    }

    return $where;
}

//Vista que muestra toda la informacion (sin salario - se modifica en la funcion getPLSalary())
function getPLFullEmployeeInfo()
{
    $permissionLevelId = $_SESSION['permissionLevelId'];

    $permission = false;

    // if (($permissionLevelId & 2))  $permission = false; // Regular Agent
    // if (($permissionLevelId & 4))  $permission = false; // Supervisor
    // if (($permissionLevelId & 8))  $permission = false; // Manager Account
    // if (($permissionLevelId & 16))  $permission = true; // HR
    // if (($permissionLevelId & 32))  $permission = true; // Operation Manager
    // if (($permissionLevelId & 64))  $permission = true; // Super Admin
    // if (($permissionLevelId & 128))  $permission = true; // Development
    // if (($permissionLevelId & 256))  $permission = false; // External person
    // if (($permissionLevelId & 512))  $permission = false; // WF
    // if (($permissionLevelId & 1024))  $permission = true; // HR jr
    if (($permissionLevelId & 1264))  $permission = true;

    return $permission;
}

// Si tiene como true la funcion getPLFullEmployeeInfo() Puede deshabilitar que se muestre toda la info sin CREAR, EDITAR ni DELETE.
function getPLCreateEditDeleteInfoEmployee()
{
    $permissionLevelId = $_SESSION['permissionLevelId'];

    $permission = false;

    // if (($permissionLevelId & 2))  $permission = false; // Regular Agent
    // if (($permissionLevelId & 4))  $permission = false; // Supervisor
    // if (($permissionLevelId & 8))  $permission = false; // Manager Account
    // if (($permissionLevelId & 16))  $permission = true; // HR
    // if (($permissionLevelId & 32))  $permission = false; // Operation Manager
    // if (($permissionLevelId & 64))  $permission = true; // Super Admin
    // if (($permissionLevelId & 128))  $permission = true; // Development
    // if (($permissionLevelId & 256))  $permission = false; // External person
    // if (($permissionLevelId & 512))  $permission = false; // WF

    if (($permissionLevelId & 1232))  $permission = true;

    return $permission;
}


// see inactivo?
function getPLShowInactiveEmployee()
{
    $permissionLevelId = $_SESSION['permissionLevelId'];
    $permission = false;

    // if (($permissionLevelId & 2))  $permission = false; // Regular Agent
    // if (($permissionLevelId & 4))  $permission = false; // Supervisor
    // if (($permissionLevelId & 8))  $permission = false; // Manager Account
    // if (($permissionLevelId & 16))  $permission = true; // HR
    // if (($permissionLevelId & 32))  $permission = true; // Operation Manager
    // if (($permissionLevelId & 64))  $permission = true; // Super Admin
    // if (($permissionLevelId & 128))  $permission = true; // Development
    // if (($permissionLevelId & 256))  $permission = false; // External person
    // if (($permissionLevelId & 512))  $permission = true; // WF

    if (($permissionLevelId & 1776))  $permission = true;

    return $permission;
}


// see salary?
function getPLSalary()
{
    $permissionLevelId = $_SESSION['permissionLevelId'];
    $permission = false;

    // if (($permissionLevelId & 2))  $permission = false; // Regular Agent
    // if (($permissionLevelId & 4))  $permission = false; // Supervisor
    // if (($permissionLevelId & 8))  $permission = false; // Manager Account
    // if (($permissionLevelId & 16))  $permission = true; // HR
    // if (($permissionLevelId & 32))  $permission = true; // Operation Manager
    // if (($permissionLevelId & 64))  $permission = true; // Super Admin
    // if (($permissionLevelId & 128))  $permission = true; // Development
    // if (($permissionLevelId & 256))  $permission = false; // External person
    // if (($permissionLevelId & 512))  $permission = false; // WF
    if (($permissionLevelId & 240))  $permission = true;

    return $permission;
}

// see Salary Adjustment, see Attritions
function getPLSAA()
{
    $permissionLevelId = $_SESSION['permissionLevelId'];
    $permission = false;

    // if (($permissionLevelId & 512))  $permission = false; // WF
    // if (($permissionLevelId & 2))  $permission = false; // Regular Agent
    // if (($permissionLevelId & 4))  $permission = false; // Supervisor
    // if (($permissionLevelId & 8))  $permission = false; // Manager Account
    // if (($permissionLevelId & 16))  $permission = true; // HR
    // if (($permissionLevelId & 32))  $permission = false; // Operation Manager
    // if (($permissionLevelId & 64))  $permission = true; // Super Admin
    // if (($permissionLevelId & 128))  $permission = true; // Development
    // if (($permissionLevelId & 256))  $permission = false; // External person

    if (($permissionLevelId & 208))  $permission = true;
    

    return $permission;
}

// see Reports?
function getPLReports()
{
    $permissionLevelId = $_SESSION['permissionLevelId'];
    $permission = false;

    // if (($permissionLevelId & 2))  $permission = false; // Regular Agent
    // if (($permissionLevelId & 4))  $permission = false; // Supervisor
    // if (($permissionLevelId & 8))  $permission = false; // Manager Account
    // if (($permissionLevelId & 16))  $permission = true; // HR
    // if (($permissionLevelId & 32))  $permission = false; // Operation Manager
    // if (($permissionLevelId & 64))  $permission = true; // Super Admin
    // if (($permissionLevelId & 128))  $permission = true; // Development
    // if (($permissionLevelId & 256))  $permission = true; // External person
    // if (($permissionLevelId & 512))  $permission = true; // WF
    #512+256+128+64+16=976
    if (($permissionLevelId & 2000))  $permission = true;

    return $permission;
}

/**
 * Method getPLUsers
 * CRUD user module.
 * 
 * Super Admin - 64
 * Development - 128
 * WF - 512
 * TOTAL 704
 *
 * @return bool
 */
function getPLUsers()
{
    $permissionLevelId = $_SESSION['permissionLevelId'];
    $permission = false;
    if (($permissionLevelId & 704))  $permission = true;

    return $permission;
}


/**
 * Method getPLAnotherBillTo
 * 
 * HR - 16
 * Super Admin - 64
 * Development - 128
 * WF - 512
 * TOTAL 720
 *
 * @return bool
 */
function getPLAnotherBillTo()
{
    $permissionLevelId = $_SESSION['permissionLevelId'];
    $permission = false;
    if (($permissionLevelId & 720))  $permission = true;
    return $permission;
}


/**
 * Method getPLAps
 * CRUD APS module.
 * 
 * Super Admin - 64
 * Development - 128
 * WF - 512
 * SUP - 4
 * Account MAN - 8
 * Op Man - 32
 * HR - 16
 * TOTAL 764
 *
 * @return bool
 */
function getPLAps()
{
    $permissionLevelId = $_SESSION['permissionLevelId'];
    $permission = false;
    if (($permissionLevelId & 1788))  $permission = true;

    return $permission;
}
