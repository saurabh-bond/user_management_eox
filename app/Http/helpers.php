<?php

function apiResponse($statusCode, $msg, $err = null, $data = [])
{
        return json_encode([
                'status' => $statusCode,
                'message' => $msg,
                'error' => $err,
                'data' => $data
        ]);
}
