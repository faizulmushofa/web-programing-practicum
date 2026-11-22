<?php

namespace App\Utils;

require_once __DIR__ . '/../service/authService.php';

use InvalidArgumentException;
use OutOfBoundsException;
use DomainException;
use Exception;
use App\Service\UnauthorizedAccessException;

class Handler {
    
    public static function run(callable $callback): void {
        try {
            $callback();
        } catch (InvalidArgumentException $e) {
            Response::error($e->getMessage(), null, 400);
        } catch (UnauthorizedAccessException $e) {
            Response::error($e->getMessage(), null, 401);
        } catch (OutOfBoundsException $e) {
            Response::error($e->getMessage(), null, 404);
        } catch (DomainException $e) {
            Response::error($e->getMessage(), null, 409);
        } catch (Exception $e) {
            Response::error($e->getMessage(), null, 500);
        }
    }
}
