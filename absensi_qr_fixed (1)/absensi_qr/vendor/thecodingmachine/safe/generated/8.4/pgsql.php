<?php

namespace Safe;

use Safe\Exceptions\PgsqlException;

/**
 * @param \PgSql\Connection $koneksiection
 * @throws PgsqlException
 *
 */
function pg_cancel_query(\PgSql\Connection $koneksiection): void
{
    error_clear_last();
    $safeResult = \pg_cancel_query($koneksiection);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param string $koneksiection_string
 * @param int $flags
 * @return \PgSql\Connection
 * @throws PgsqlException
 *
 */
function pg_connect(string $koneksiection_string, int $flags = 0): \PgSql\Connection
{
    error_clear_last();
    $safeResult = \pg_connect($koneksiection_string, $flags);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection $koneksiection
 * @throws PgsqlException
 *
 */
function pg_connection_reset(\PgSql\Connection $koneksiection): void
{
    error_clear_last();
    $safeResult = \pg_connection_reset($koneksiection);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $table_name
 * @param array $values
 * @param int $flags
 * @return array
 * @throws PgsqlException
 *
 */
function pg_convert(\PgSql\Connection $koneksiection, string $table_name, array $values, int $flags = 0): array
{
    error_clear_last();
    $safeResult = \pg_convert($koneksiection, $table_name, $values, $flags);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $table_name
 * @param array $rows
 * @param string $separator
 * @param string $null_as
 * @throws PgsqlException
 *
 */
function pg_copy_from(\PgSql\Connection $koneksiection, string $table_name, array $rows, string $separator = "\t", string $null_as = "\\\\N"): void
{
    error_clear_last();
    $safeResult = \pg_copy_from($koneksiection, $table_name, $rows, $separator, $null_as);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $table_name
 * @param string $separator
 * @param string $null_as
 * @return array
 * @throws PgsqlException
 *
 */
function pg_copy_to(\PgSql\Connection $koneksiection, string $table_name, string $separator = "\t", string $null_as = "\\\\N"): array
{
    error_clear_last();
    $safeResult = \pg_copy_to($koneksiection, $table_name, $separator, $null_as);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $table_name
 * @param array $conditions
 * @param int $flags
 * @return mixed
 * @throws PgsqlException
 *
 */
function pg_delete(\PgSql\Connection $koneksiection, string $table_name, array $conditions, int $flags = PGSQL_DML_EXEC)
{
    error_clear_last();
    $safeResult = \pg_delete($koneksiection, $table_name, $conditions, $flags);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection|null $koneksiection
 * @throws PgsqlException
 *
 */
function pg_end_copy(?\PgSql\Connection $koneksiection = null): void
{
    error_clear_last();
    if ($koneksiection !== null) {
        $safeResult = \pg_end_copy($koneksiection);
    } else {
        $safeResult = \pg_end_copy();
    }
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $stmtname
 * @param array $params
 * @return \PgSql\Result
 * @throws PgsqlException
 *
 */
function pg_execute(?\PgSql\Connection $koneksiection = null, ?string $stmtname = null, ?array $params = null): \PgSql\Result
{
    error_clear_last();
    if ($params !== null) {
        $safeResult = \pg_execute($koneksiection, $stmtname, $params);
    } elseif ($stmtname !== null) {
        $safeResult = \pg_execute($koneksiection, $stmtname);
    } elseif ($koneksiection !== null) {
        $safeResult = \pg_execute($koneksiection);
    } else {
        $safeResult = \pg_execute();
    }
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Result $result
 * @param string $field
 * @return int
 * @throws PgsqlException
 *
 */
function pg_field_num(\PgSql\Result $result, string $field): int
{
    error_clear_last();
    $safeResult = \pg_field_num($result, $field);
    if ($safeResult === -1) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Result $result
 * @param int $field
 * @param bool $oid_only
 * @return mixed
 * @throws PgsqlException
 *
 */
function pg_field_table(\PgSql\Result $result, int $field, bool $oid_only = false)
{
    error_clear_last();
    $safeResult = \pg_field_table($result, $field, $oid_only);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection $koneksiection
 * @return mixed
 * @throws PgsqlException
 *
 */
function pg_flush(\PgSql\Connection $koneksiection)
{
    error_clear_last();
    $safeResult = \pg_flush($koneksiection);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Result $result
 * @throws PgsqlException
 *
 */
function pg_free_result(\PgSql\Result $result): void
{
    error_clear_last();
    $safeResult = \pg_free_result($result);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Connection|null $koneksiection
 * @return string
 * @throws PgsqlException
 *
 */
function pg_host(?\PgSql\Connection $koneksiection = null): string
{
    error_clear_last();
    if ($koneksiection !== null) {
        $safeResult = \pg_host($koneksiection);
    } else {
        $safeResult = \pg_host();
    }
    if ($safeResult === '') {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $table_name
 * @param array $values
 * @param int $flags
 * @return mixed
 * @throws PgsqlException
 *
 */
function pg_insert(\PgSql\Connection $koneksiection, string $table_name, array $values, int $flags = PGSQL_DML_EXEC)
{
    error_clear_last();
    $safeResult = \pg_insert($koneksiection, $table_name, $values, $flags);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Result $result
 * @return string
 * @throws PgsqlException
 *
 */
function pg_last_oid(\PgSql\Result $result): string
{
    error_clear_last();
    $safeResult = \pg_last_oid($result);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Lob $lob
 * @throws PgsqlException
 *
 */
function pg_lo_close(\PgSql\Lob $lob): void
{
    error_clear_last();
    $safeResult = \pg_lo_close($lob);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param int $oid
 * @param string $pathname
 * @throws PgsqlException
 *
 */
function pg_lo_export(?\PgSql\Connection $koneksiection = null, ?int $oid = null, ?string $pathname = null): void
{
    error_clear_last();
    if ($pathname !== null) {
        $safeResult = \pg_lo_export($koneksiection, $oid, $pathname);
    } elseif ($oid !== null) {
        $safeResult = \pg_lo_export($koneksiection, $oid);
    } elseif ($koneksiection !== null) {
        $safeResult = \pg_lo_export($koneksiection);
    } else {
        $safeResult = \pg_lo_export();
    }
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $pathname
 * @param  $object_id
 * @return int
 * @throws PgsqlException
 *
 */
function pg_lo_import(?\PgSql\Connection $koneksiection = null, ?string $pathname = null, $object_id = null): int
{
    error_clear_last();
    if ($object_id !== null) {
        $safeResult = \pg_lo_import($koneksiection, $pathname, $object_id);
    } elseif ($pathname !== null) {
        $safeResult = \pg_lo_import($koneksiection, $pathname);
    } elseif ($koneksiection !== null) {
        $safeResult = \pg_lo_import($koneksiection);
    } else {
        $safeResult = \pg_lo_import();
    }
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param int $oid
 * @param string $mode
 * @return \PgSql\Lob
 * @throws PgsqlException
 *
 */
function pg_lo_open(\PgSql\Connection $koneksiection, int $oid, string $mode): \PgSql\Lob
{
    error_clear_last();
    $safeResult = \pg_lo_open($koneksiection, $oid, $mode);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Lob $lob
 * @param int $length
 * @return string
 * @throws PgsqlException
 *
 */
function pg_lo_read(\PgSql\Lob $lob, int $length = 8192): string
{
    error_clear_last();
    $safeResult = \pg_lo_read($lob, $length);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Lob $lob
 * @param int $offset
 * @param int $whence
 * @throws PgsqlException
 *
 */
function pg_lo_seek(\PgSql\Lob $lob, int $offset, int $whence = SEEK_CUR): void
{
    error_clear_last();
    $safeResult = \pg_lo_seek($lob, $offset, $whence);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Lob $lob
 * @param int $size
 * @throws PgsqlException
 *
 */
function pg_lo_truncate(\PgSql\Lob $lob, int $size): void
{
    error_clear_last();
    $safeResult = \pg_lo_truncate($lob, $size);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param int $oid
 * @throws PgsqlException
 *
 */
function pg_lo_unlink(\PgSql\Connection $koneksiection, int $oid): void
{
    error_clear_last();
    $safeResult = \pg_lo_unlink($koneksiection, $oid);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Lob $lob
 * @param string $data
 * @param int|null $length
 * @return int
 * @throws PgsqlException
 *
 */
function pg_lo_write(\PgSql\Lob $lob, string $data, ?int $length = null): int
{
    error_clear_last();
    if ($length !== null) {
        $safeResult = \pg_lo_write($lob, $data, $length);
    } else {
        $safeResult = \pg_lo_write($lob, $data);
    }
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $table_name
 * @param bool $extended
 * @return array
 * @throws PgsqlException
 *
 */
function pg_meta_data(\PgSql\Connection $koneksiection, string $table_name, bool $extended = false): array
{
    error_clear_last();
    $safeResult = \pg_meta_data($koneksiection, $table_name, $extended);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $param_name
 * @return string
 * @throws PgsqlException
 *
 */
function pg_parameter_status(?\PgSql\Connection $koneksiection = null, ?string $param_name = null): string
{
    error_clear_last();
    if ($param_name !== null) {
        $safeResult = \pg_parameter_status($koneksiection, $param_name);
    } elseif ($koneksiection !== null) {
        $safeResult = \pg_parameter_status($koneksiection);
    } else {
        $safeResult = \pg_parameter_status();
    }
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param string $koneksiection_string
 * @param int $flags
 * @return \PgSql\Connection
 * @throws PgsqlException
 *
 */
function pg_pconnect(string $koneksiection_string, int $flags = 0): \PgSql\Connection
{
    error_clear_last();
    $safeResult = \pg_pconnect($koneksiection_string, $flags);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection|null $koneksiection
 * @throws PgsqlException
 *
 */
function pg_ping(?\PgSql\Connection $koneksiection = null): void
{
    error_clear_last();
    if ($koneksiection !== null) {
        $safeResult = \pg_ping($koneksiection);
    } else {
        $safeResult = \pg_ping();
    }
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $stmtname
 * @param string $query
 * @return \PgSql\Result
 * @throws PgsqlException
 *
 */
function pg_prepare(?\PgSql\Connection $koneksiection = null, ?string $stmtname = null, ?string $query = null): \PgSql\Result
{
    error_clear_last();
    if ($query !== null) {
        $safeResult = \pg_prepare($koneksiection, $stmtname, $query);
    } elseif ($stmtname !== null) {
        $safeResult = \pg_prepare($koneksiection, $stmtname);
    } elseif ($koneksiection !== null) {
        $safeResult = \pg_prepare($koneksiection);
    } else {
        $safeResult = \pg_prepare();
    }
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $data
 * @throws PgsqlException
 *
 */
function pg_put_line(?\PgSql\Connection $koneksiection = null, ?string $data = null): void
{
    error_clear_last();
    if ($data !== null) {
        $safeResult = \pg_put_line($koneksiection, $data);
    } elseif ($koneksiection !== null) {
        $safeResult = \pg_put_line($koneksiection);
    } else {
        $safeResult = \pg_put_line();
    }
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $query
 * @param array $params
 * @return \PgSql\Result
 * @throws PgsqlException
 *
 */
function pg_query_params(?\PgSql\Connection $koneksiection = null, ?string $query = null, ?array $params = null): \PgSql\Result
{
    error_clear_last();
    if ($params !== null) {
        $safeResult = \pg_query_params($koneksiection, $query, $params);
    } elseif ($query !== null) {
        $safeResult = \pg_query_params($koneksiection, $query);
    } elseif ($koneksiection !== null) {
        $safeResult = \pg_query_params($koneksiection);
    } else {
        $safeResult = \pg_query_params();
    }
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $query
 * @return \PgSql\Result
 * @throws PgsqlException
 *
 */
function pg_query(?\PgSql\Connection $koneksiection = null, ?string $query = null): \PgSql\Result
{
    error_clear_last();
    if ($query !== null) {
        $safeResult = \pg_query($koneksiection, $query);
    } elseif ($koneksiection !== null) {
        $safeResult = \pg_query($koneksiection);
    } else {
        $safeResult = \pg_query();
    }
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Result $result
 * @param int $field_code
 * @return null|string
 * @throws PgsqlException
 *
 */
function pg_result_error_field(\PgSql\Result $result, int $field_code): ?string
{
    error_clear_last();
    $safeResult = \pg_result_error_field($result, $field_code);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Result $result
 * @param int $row
 * @throws PgsqlException
 *
 */
function pg_result_seek(\PgSql\Result $result, int $row): void
{
    error_clear_last();
    $safeResult = \pg_result_seek($result, $row);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $table_name
 * @param array $conditions
 * @param int $flags
 * @param int $mode
 * @return mixed
 * @throws PgsqlException
 *
 */
function pg_select(\PgSql\Connection $koneksiection, string $table_name, array $conditions = [], int $flags = PGSQL_DML_EXEC, int $mode = PGSQL_ASSOC)
{
    error_clear_last();
    $safeResult = \pg_select($koneksiection, $table_name, $conditions, $flags, $mode);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param int $size
 * @throws PgsqlException
 *
 */
function pg_set_chunked_rows_size(\PgSql\Connection $koneksiection, int $size): void
{
    error_clear_last();
    $safeResult = \pg_set_chunked_rows_size($koneksiection, $size);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Connection $koneksiection
 * @return resource
 * @throws PgsqlException
 *
 */
function pg_socket(\PgSql\Connection $koneksiection)
{
    error_clear_last();
    $safeResult = \pg_socket($koneksiection);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param string $filename
 * @param string $mode
 * @param \PgSql\Connection|null $koneksiection
 * @param int $trace_mode
 * @throws PgsqlException
 *
 */
function pg_trace(string $filename, string $mode = "w", ?\PgSql\Connection $koneksiection = null, int $trace_mode = 0): void
{
    error_clear_last();
    if ($trace_mode !== 0) {
        $safeResult = \pg_trace($filename, $mode, $koneksiection, $trace_mode);
    } elseif ($koneksiection !== null) {
        $safeResult = \pg_trace($filename, $mode, $koneksiection);
    } else {
        $safeResult = \pg_trace($filename, $mode);
    }
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
}


/**
 * @param \PgSql\Connection $koneksiection
 * @param string $table_name
 * @param array $values
 * @param array $conditions
 * @param int $flags
 * @return mixed
 * @throws PgsqlException
 *
 */
function pg_update(\PgSql\Connection $koneksiection, string $table_name, array $values, array $conditions, int $flags = PGSQL_DML_EXEC)
{
    error_clear_last();
    $safeResult = \pg_update($koneksiection, $table_name, $values, $conditions, $flags);
    if ($safeResult === false) {
        throw PgsqlException::createFromPhpError();
    }
    return $safeResult;
}
