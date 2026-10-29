<?php

namespace Safe;

use Safe\Exceptions\Oci8Exception;

/**
 * @param resource $statement
 * @param string $param
 * @param array $var
 * @param int $max_array_length
 * @param int $max_item_length
 * @param int $type
 * @throws Oci8Exception
 *
 */
function oci_bind_array_by_name($statement, string $param, array &$var, int $max_array_length, int $max_item_length = -1, int $type = SQLT_AFC): void
{
    error_clear_last();
    $safeResult = \oci_bind_array_by_name($statement, $param, $var, $max_array_length, $max_item_length, $type);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $statement
 * @param string $param
 * @param mixed $var
 * @param int $max_length
 * @param int $type
 * @throws Oci8Exception
 *
 */
function oci_bind_by_name($statement, string $param, &$var, int $max_length = -1, int $type = 0): void
{
    error_clear_last();
    $safeResult = \oci_bind_by_name($statement, $param, $var, $max_length, $type);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $statement
 * @throws Oci8Exception
 *
 */
function oci_cancel($statement): void
{
    error_clear_last();
    $safeResult = \oci_cancel($statement);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $koneksiection
 * @throws Oci8Exception
 *
 */
function oci_commit($koneksiection): void
{
    error_clear_last();
    $safeResult = \oci_commit($koneksiection);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param string $username
 * @param string $password
 * @param null|string $koneksiection_string
 * @param string $encoding
 * @param int $session_mode
 * @return resource
 * @throws Oci8Exception
 *
 */
function oci_connect(string $username, string $password, ?string $koneksiection_string = null, string $encoding = "", int $session_mode = OCI_DEFAULT)
{
    error_clear_last();
    if ($session_mode !== OCI_DEFAULT) {
        $safeResult = \oci_connect($username, $password, $koneksiection_string, $encoding, $session_mode);
    } elseif ($encoding !== "") {
        $safeResult = \oci_connect($username, $password, $koneksiection_string, $encoding);
    } elseif ($koneksiection_string !== null) {
        $safeResult = \oci_connect($username, $password, $koneksiection_string);
    } else {
        $safeResult = \oci_connect($username, $password);
    }
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $statement
 * @param string $column
 * @param mixed $var
 * @param int $type
 * @throws Oci8Exception
 *
 */
function oci_define_by_name($statement, string $column, &$var, int $type = 0): void
{
    error_clear_last();
    $safeResult = \oci_define_by_name($statement, $column, $var, $type);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $statement
 * @param int $mode
 * @throws Oci8Exception
 *
 */
function oci_execute($statement, int $mode = OCI_COMMIT_ON_SUCCESS): void
{
    error_clear_last();
    $safeResult = \oci_execute($statement, $mode);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $statement
 * @param mixed $column
 * @return string
 * @throws Oci8Exception
 *
 */
function oci_field_name($statement, $column): string
{
    error_clear_last();
    $safeResult = \oci_field_name($statement, $column);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $statement
 * @param mixed $column
 * @return int
 * @throws Oci8Exception
 *
 */
function oci_field_precision($statement, $column): int
{
    error_clear_last();
    $safeResult = \oci_field_precision($statement, $column);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $statement
 * @param mixed $column
 * @return int
 * @throws Oci8Exception
 *
 */
function oci_field_scale($statement, $column): int
{
    error_clear_last();
    $safeResult = \oci_field_scale($statement, $column);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $statement
 * @param mixed $column
 * @return int
 * @throws Oci8Exception
 *
 */
function oci_field_size($statement, $column): int
{
    error_clear_last();
    $safeResult = \oci_field_size($statement, $column);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $statement
 * @param mixed $column
 * @return int
 * @throws Oci8Exception
 *
 */
function oci_field_type_raw($statement, $column): int
{
    error_clear_last();
    $safeResult = \oci_field_type_raw($statement, $column);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $statement
 * @param mixed $column
 * @return mixed
 * @throws Oci8Exception
 *
 */
function oci_field_type($statement, $column)
{
    error_clear_last();
    $safeResult = \oci_field_type($statement, $column);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \OCILob $lob
 * @throws Oci8Exception
 *
 */
function oci_free_descriptor(\OCILob $lob): void
{
    error_clear_last();
    $safeResult = \oci_free_descriptor($lob);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $statement
 * @throws Oci8Exception
 *
 */
function oci_free_statement($statement): void
{
    error_clear_last();
    $safeResult = \oci_free_statement($statement);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $koneksiection
 * @param string $type_name
 * @param null|string $schema
 * @return \OCI-Collection
 * @throws Oci8Exception
 *
 */
function oci_new_collection($koneksiection, string $type_name, ?string $schema = null)
{
    error_clear_last();
    if ($schema !== null) {
        $safeResult = \oci_new_collection($koneksiection, $type_name, $schema);
    } else {
        $safeResult = \oci_new_collection($koneksiection, $type_name);
    }
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param string $username
 * @param string $password
 * @param null|string $koneksiection_string
 * @param string $encoding
 * @param int $session_mode
 * @return resource
 * @throws Oci8Exception
 *
 */
function oci_new_connect(string $username, string $password, ?string $koneksiection_string = null, string $encoding = "", int $session_mode = OCI_DEFAULT)
{
    error_clear_last();
    if ($session_mode !== OCI_DEFAULT) {
        $safeResult = \oci_new_connect($username, $password, $koneksiection_string, $encoding, $session_mode);
    } elseif ($encoding !== "") {
        $safeResult = \oci_new_connect($username, $password, $koneksiection_string, $encoding);
    } elseif ($koneksiection_string !== null) {
        $safeResult = \oci_new_connect($username, $password, $koneksiection_string);
    } else {
        $safeResult = \oci_new_connect($username, $password);
    }
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $koneksiection
 * @return resource
 * @throws Oci8Exception
 *
 */
function oci_new_cursor($koneksiection)
{
    error_clear_last();
    $safeResult = \oci_new_cursor($koneksiection);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $koneksiection
 * @param int $type
 * @return \OCI-Lob|false
 * @throws Oci8Exception
 *
 */
function oci_new_descriptor($koneksiection, int $type = OCI_DTYPE_LOB)
{
    error_clear_last();
    $safeResult = \oci_new_descriptor($koneksiection, $type);
    if ($safeResult === null) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $statement
 * @return 0|positive-int
 * @throws Oci8Exception
 *
 */
function oci_num_rows($statement): int
{
    error_clear_last();
    $safeResult = \oci_num_rows($statement);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $koneksiection
 * @param string $sql
 * @return resource
 * @throws Oci8Exception
 *
 */
function oci_parse($koneksiection, string $sql)
{
    error_clear_last();
    $safeResult = \oci_parse($koneksiection, $sql);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param string $username
 * @param string $password
 * @param null|string $koneksiection_string
 * @param string $encoding
 * @param int $session_mode
 * @return resource
 * @throws Oci8Exception
 *
 */
function oci_pconnect(string $username, string $password, ?string $koneksiection_string = null, string $encoding = "", int $session_mode = OCI_DEFAULT)
{
    error_clear_last();
    if ($session_mode !== OCI_DEFAULT) {
        $safeResult = \oci_pconnect($username, $password, $koneksiection_string, $encoding, $session_mode);
    } elseif ($encoding !== "") {
        $safeResult = \oci_pconnect($username, $password, $koneksiection_string, $encoding);
    } elseif ($koneksiection_string !== null) {
        $safeResult = \oci_pconnect($username, $password, $koneksiection_string);
    } else {
        $safeResult = \oci_pconnect($username, $password);
    }
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $koneksiection
 * @param callable $callback
 * @throws Oci8Exception
 *
 */
function oci_register_taf_callback($koneksiection, callable $callback): void
{
    error_clear_last();
    $safeResult = \oci_register_taf_callback($koneksiection, $callback);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $statement
 * @param mixed $column
 * @return string
 * @throws Oci8Exception
 *
 */
function oci_result($statement, $column): string
{
    error_clear_last();
    $safeResult = \oci_result($statement, $column);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $koneksiection
 * @throws Oci8Exception
 *
 */
function oci_rollback($koneksiection): void
{
    error_clear_last();
    $safeResult = \oci_rollback($koneksiection);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $koneksiection
 * @return string
 * @throws Oci8Exception
 *
 */
function oci_server_version($koneksiection): string
{
    error_clear_last();
    $safeResult = \oci_server_version($koneksiection);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $koneksiection
 * @param string $action
 * @throws Oci8Exception
 *
 */
function oci_set_action($koneksiection, string $action): void
{
    error_clear_last();
    $safeResult = \oci_set_action($koneksiection, $action);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $koneksiection
 * @param int $timeout
 * @throws Oci8Exception
 *
 */
function oci_set_call_timeout($koneksiection, int $timeout): void
{
    error_clear_last();
    $safeResult = \oci_set_call_timeout($koneksiection, $timeout);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $koneksiection
 * @param string $client_id
 * @throws Oci8Exception
 *
 */
function oci_set_client_identifier($koneksiection, string $client_id): void
{
    error_clear_last();
    $safeResult = \oci_set_client_identifier($koneksiection, $client_id);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $koneksiection
 * @param string $client_info
 * @throws Oci8Exception
 *
 */
function oci_set_client_info($koneksiection, string $client_info): void
{
    error_clear_last();
    $safeResult = \oci_set_client_info($koneksiection, $client_info);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $koneksiection
 * @param string $action
 * @throws Oci8Exception
 *
 */
function oci_set_db_operation($koneksiection, string $action): void
{
    error_clear_last();
    $safeResult = \oci_set_db_operation($koneksiection, $action);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param string $edition
 * @throws Oci8Exception
 *
 */
function oci_set_edition(string $edition): void
{
    error_clear_last();
    $safeResult = \oci_set_edition($edition);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $koneksiection
 * @param string $name
 * @throws Oci8Exception
 *
 */
function oci_set_module_name($koneksiection, string $name): void
{
    error_clear_last();
    $safeResult = \oci_set_module_name($koneksiection, $name);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $statement
 * @param int $rows
 * @throws Oci8Exception
 *
 */
function oci_set_prefetch($statement, int $rows): void
{
    error_clear_last();
    $safeResult = \oci_set_prefetch($statement, $rows);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}


/**
 * @param resource $statement
 * @return string
 * @throws Oci8Exception
 *
 */
function oci_statement_type($statement): string
{
    error_clear_last();
    $safeResult = \oci_statement_type($statement);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $koneksiection
 * @throws Oci8Exception
 *
 */
function oci_unregister_taf_callback($koneksiection): void
{
    error_clear_last();
    $safeResult = \oci_unregister_taf_callback($koneksiection);
    if ($safeResult === false) {
        throw Oci8Exception::createFromPhpError();
    }
}
