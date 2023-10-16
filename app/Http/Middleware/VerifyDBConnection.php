<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class VerifyDBConnection
{
    public static function getDB(Request $request)
    {
        switch ($request->header('DB-Connection')) {
            case strtoupper("previne"):
                config([
                    'database.connections.mysql.database' => 'safety_novo',
                    'database.connections.mysql.username' => 'novo',
                    'database.connections.mysql.password' => 'aUMnbtq)Q3vKQ0FY',
                ]);
                break;

            case strtoupper("cmaa"):
                config([
                    'database.connections.mysql.database' => 'cmaa',
                    'database.connections.mysql.username' => 'cmaa',
                    'database.connections.mysql.password' => 'JfaP*8XpDmkT!m%126!2oyXj',
                ]);
                break;

            case strtoupper("lins"):
                config([
                    'database.connections.mysql.database' => 'lins',
                    'database.connections.mysql.username' => 'lins',
                    'database.connections.mysql.password' => 'L^d9KulsYL^UYxs^1zkI4a1O',
                ]);
                break;
        }
    }
}