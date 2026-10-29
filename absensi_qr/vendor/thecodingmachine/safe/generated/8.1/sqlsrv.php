<?php

namespace Safe;

use Safe\Exceptions\SqlsrvException;

/**
 * @param resource $koneksi
 * @throws SqlsrvException
 *
 */
function sqlsrv_begin_transaction($koneksi): void
{
    error_clear_last();
    $safeResult = \sqlsrv_begin_transaction($koneksi);
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
}


/**
 * @param resource $stmt
 * @throws SqlsrvException
 *
 */
function sqlsrv_cancel($stmt): void
{
    error_clear_last();
    $safeResult = \sqlsrv_cancel($stmt);
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
}


/**
 * @param resource $koneksi
 * @return array
 * @throws SqlsrvException
 *
 */
function sqlsrv_client_info($koneksi): array
{
    error_clear_last();
    $safeResult = \sqlsrv_client_info($koneksi);
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $koneksi
 * @throws SqlsrvException
 *
 */
function sqlsrv_close($koneksi): void
{
    error_clear_last();
    $safeResult = \sqlsrv_close($koneksi);
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
}


/**
 * @param resource $koneksi
 * @throws SqlsrvException
 *
 */
function sqlsrv_commit($koneksi): void
{
    error_clear_last();
    $safeResult = \sqlsrv_commit($koneksi);
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
}


/**
 * @param string $setting
 * @param mixed $value
 * @throws SqlsrvException
 *
 */
function sqlsrv_configure(string $setting, $value): void
{
    error_clear_last();
    $safeResult = \sqlsrv_configure($setting, $value);
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
}


/**
 * @param resource $stmt
 * @throws SqlsrvException
 *
 */
function sqlsrv_execute($stmt): void
{
    error_clear_last();
    $safeResult = \sqlsrv_execute($stmt);
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
}


/**
 * @param resource $stmt
 * @param int $fetchType
 * @param int $row
 * @param int $offset
 * @return array|null
 * @throws SqlsrvException
 *
 */
function sqlsrv_fetch_array($stmt, ?int $fetchType = null, ?int $row = null, ?int $offset = null): ?array
{
    error_clear_last();
    if ($offset !== null) {
        $safeResult = \sqlsrv_fetch_array($stmt, $fetchType, $row, $offset);
    } elseif ($row !== null) {
        $safeResult = \sqlsrv_fetch_array($stmt, $fetchType, $row);
    } elseif ($fetchType !== null) {
        $safeResult = \sqlsrv_fetch_array($stmt, $fetchType);
    } else {
        $safeResult = \sqlsrv_fetch_array($stmt);
    }
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $stmt
 * @param string $className
 * @param array $ctorParams
 * @param int $row
 * @param int $offset
 * @return null|object
 * @throws SqlsrvException
 *
 */
function sqlsrv_fetch_object($stmt, ?string $className = null, ?array $ctorParams = null, ?int $row = null, ?int $offset = null): ?object
{
    error_clear_last();
    if ($offset !== null) {
        $safeResult = \sqlsrv_fetch_object($stmt, $className, $ctorParams, $row, $offset);
    } elseif ($row !== null) {
        $safeResult = \sqlsrv_fetch_object($stmt, $className, $ctorParams, $row);
    } elseif ($ctorParams !== null) {
        $safeResult = \sqlsrv_fetch_object($stmt, $className, $ctorParams);
    } elseif ($className !== null) {
        $safeResult = \sqlsrv_fetch_object($stmt, $className);
    } else {
        $safeResult = \sqlsrv_fetch_object($stmt);
    }
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $stmt
 * @param int $row
 * @param int $offset
 * @return bool|null
 * @throws SqlsrvException
 *
 */
function sqlsrv_fetch($stmt, ?int $row = null, ?int $offset = null): ?bool
{
    error_clear_last();
    if ($offset !== null) {
        $safeResult = \sqlsrv_fetch($stmt, $row, $offset);
    } elseif ($row !== null) {
        $safeResult = \sqlsrv_fetch($stmt, $row);
    } else {
        $safeResult = \sqlsrv_fetch($stmt);
    }
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $stmt
 * @throws SqlsrvException
 *
 */
function sqlsrv_free_stmt($stmt): void
{
    error_clear_last();
    $safeResult = \sqlsrv_free_stmt($stmt);
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
}


/**
 * @param resource $stmt
 * @param int $fieldIndex
 * @param int $getAsType
 * @return mixed
 * @throws SqlsrvException
 *
 */
function sqlsrv_get_field($stmt, int $fieldIndex, ?int $getAsType = null)
{
    error_clear_last();
    if ($getAsType !== null) {
        $safeResult = \sqlsrv_get_field($stmt, $fieldIndex, $getAsType);
    } else {
        $safeResult = \sqlsrv_get_field($stmt, $fieldIndex);
    }
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $stmt
 * @return bool|null
 * @throws SqlsrvException
 *
 */
function sqlsrv_next_result($stmt): ?bool
{
    error_clear_last();
    $safeResult = \sqlsrv_next_result($stmt);
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $stmt
 * @return int
 * @throws SqlsrvException
 *
 */
function sqlsrv_num_fields($stmt): int
{
    error_clear_last();
    $safeResult = \sqlsrv_num_fields($stmt);
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $stmt
 * @return int
 * @throws SqlsrvException
 *
 */
function sqlsrv_num_rows($stmt): int
{
    error_clear_last();
    $safeResult = \sqlsrv_num_rows($stmt);
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $koneksi
 * @param string $sql
 * @param array $params
 * @param array $options
 * @return mixed
 * @throws SqlsrvException
 *
 */
function sqlsrv_prepare($koneksi, string $sql, ?array $params = null, ?array $options = null)
{
    error_clear_last();
    if ($options !== null) {
        $safeResult = \sqlsrv_prepare($koneksi, $sql, $params, $options);
    } elseif ($params !== null) {
        $safeResult = \sqlsrv_prepare($koneksi, $sql, $params);
    } else {
        $safeResult = \sqlsrv_prepare($koneksi, $sql);
    }
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $koneksi
 * @param string $sql
 * @param array $params
 * @param array $options
 * @return mixed
 * @throws SqlsrvException
 *
 */
function sqlsrv_query($koneksi, string $sql, ?array $params = null, ?array $options = null)
{
    error_clear_last();
    if ($options !== null) {
        $safeResult = \sqlsrv_query($koneksi, $sql, $params, $options);
    } elseif ($params !== null) {
        $safeResult = \sqlsrv_query($koneksi, $sql, $params);
    } else {
        $safeResult = \sqlsrv_query($koneksi, $sql);
    }
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
    return $safeResult;
}


/**
 * @param resource $koneksi
 * @throws SqlsrvException
 *
 */
function sqlsrv_rollback($koneksi): void
{
    error_clear_last();
    $safeResult = \sqlsrv_rollback($koneksi);
    if ($safeResult === false) {
        throw SqlsrvException::createFromPhpError();
    }
}
