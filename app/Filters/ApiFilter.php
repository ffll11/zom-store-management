<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{
    protected $safeParams = [];

    protected $columnMap = [];

    protected $operatorMap = [];

    public function transform(Request $request)
    {
        $eloquentQuery = [];
        $whereIn = [];
        $orderBy = [];

        foreach ($this->safeParams as $param => $operators) {

            $query = $request->query($param);
            if (! isset($query)) {
                continue;
            }

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $column = $this->columnMap[$param] ?? $param;
                    $value = $query[$operator];
                    $eloquentOperator = $this->operatorMap[$operator] ?? null;

                    // Handle 'in' operator separately
                    if ($eloquentOperator === 'in') {
                        $values = is_array($value) ? $value : explode(',', $value);
                        $whereIn[$column] = $values;
                    }
                    // Handle ordering
                    elseif ($eloquentOperator === 'asc' || $eloquentOperator === 'desc') {
                        $orderBy[] = [$column, $eloquentOperator];
                    }
                    // Handle like operator
                    elseif ($eloquentOperator === 'like') {
                        $eloquentQuery[] = [$column, $eloquentOperator, "%{$value}%"];
                    }
                    // Handle standard operators
                    else {
                        $eloquentQuery[] = [$column, $eloquentOperator, $value];
                    }
                }
            }

            return ['filters' => $eloquentQuery, 'orderBy' => $orderBy, 'whereIn' => $whereIn];
        }

    }
        // Se itera sobre el array asociativo safeParams
    // Mostramos el value operators
    // Si el query del request tiene el valor del operador
    // Si query no esta seteado, se salta a la siguiente iteracion
    // Si existe paramos el parametro al array columnMap

    // iteramos sobre el valor operator de param
    // Si el query esta seteado con el valor del operador
    // Mapeamos el operador al array operatorMap
    // Si el operador esta seteado entonces agregamos al array asociativo eloquentQuery el array con los valores
    // $eloquentQuery[] = key , operador ,key con value
}
