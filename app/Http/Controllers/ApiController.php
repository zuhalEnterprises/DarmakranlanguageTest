<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Infrastructure\Enumerations\HeaderEnums;
use Infrastructure\Interfaces\Services\GraphqlGatewayInterface;

Class ApiController extends Controller
{
    /** @var GraphqlGatewayInterface  */
    private $graph;

    public function __construct()
    {
        $this->graph = app(\Infrastructure\Interfaces\Services\GraphqlGatewayInterface::class);

        if (
            config('app.env') == 'production'
            && request()->route()->getActionMethod() != 'userDevelopment'
        ) {
            $this->graph->enableSecurityRules();
            $this->graph->avoidThrowingException();
        }
    }

    public function user()
    {
        $query = request()->input('query');
        $variables = request()->input('variables') ?? [];

        return $this->graph->userGraph($query, $variables);
    }
    
    public function admin()
    {
        $query = request()->input('query');
        $variables = request()->input('variables') ?? [];

        $result = $this->graph->adminGraph($query, $variables);

        $this->checkLogQuery();

        return $result;
    }

    public function userDevelopment()
    {
        $query = request()->input('query');
        $variables = request()->input('variables') ?? [];

        return $this->graph->userGraph($query, $variables);
    }

    private function checkLogQuery()
    {
        if (request()->hasHeader(HeaderEnums::LOG_QUERY)) {
            dj([
                "count" => $GLOBALS['queryCount'],
                DB::connection('mysql')->getQueryLog()
            ]);
        }
    }
}
