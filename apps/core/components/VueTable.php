<?php
namespace app\core\components;

use app\system\Model;
use app\system\Query;

class VueTable {

    const DEFAULT_LIMIT = 7;

    public $dataProvider;
    public $columns;
    public $limit = 15;
    public $curPage = 0;
    public $sort;
    protected $offset = 0;

    public static function getData($data) {
        $limit = $data['limit'] ?? static::DEFAULT_LIMIT;
        $curPage = $data['curPage'] ?? 1;

        /** @var $query Query */
        $query = $data['query'];

        $data['filter'] = json_decode($data['filter'], 1);
        if (isset($data['filter'])) {
            foreach ($data['filter'] as $attr => $value) {
                if (strlen($value) > 0) {
                    $query->where([$attr => $value]);
                }
            }
        }

        $totalCount = $query->count();

        $pagination = [
            'pageCount' => ceil($totalCount / $limit),
            'curPage' => (int)$curPage,
            'offset' => $limit * ($curPage - 1),
            'totalCount' => (int)$totalCount,
            'limit' => (int)$limit
        ];

        if ($curPage > $pagination['pageCount']) {
            $pagination['curPage'] = 1;
            $pagination['offset'] = 0;
        }

        if ($totalCount > 0) {
            $data['columns'][] = [
                'attribute' => 'id',
                'visible' => false
            ];

            // либо указанную сортировку применяем, или же коли нет её - по умолчанию
            $sort = $data['sort'] ?? null;
            $direction = $data['direction'] ?? null;

            if (isset($sort)) {
                $query = $query->addOrderBy($sort . ' ' . $direction);

            } else {
                //$provider->sort->setAttributeOrders($defaultOrder = $provider->sort->defaultOrder);
                //$query = $query->addOrderBy($defaultOrder);
                //$sort = $sort ?? (key($defaultOrder));
               $direction = 'asc';
            }

            $query = $query->limit($limit)->offset($pagination['offset']);

            if (isset($data['filter'])) {
                foreach ($data['filter'] as $attr => $value) {
                    $query = strlen($value) ? $query->where([$attr => $value]) : $query;
                }
            }

            $result = $query->asArray()->all();

            $rows = [];

            foreach ($result as $pkey => $row) {
                $rowData = [];
                foreach ($data['columns'] as $key => $cell) {
                    $attrName = $cell['attribute'] ?? null;
                    $closure = $cell['value'] ?? null;

                    if (is_callable($closure)) {
                        $rowData[$attrName]['value'] = $closure($row);
                    } else {
                        $rowData[$attrName]['value'] = $row[$attrName] ?? null;
                    }

                    $rowData[$attrName]['val'] = $rowData[$attrName] ?? null;
                 }
                $rows[] = $rowData;
             }
        }

        foreach ($data['columns'] as $key => &$cell) {
            $cell['visible'] = $cell['visible'] ?? true;
            $cell['label'] = $cell['label'] ?? (isset($cell['attribute']) && $cell['attribute'] ? $query->getModelClass()::getLabel($cell['attribute']) : '');
            $cell['sort'] = 'id'; // isset($cell['attribute']) && $provider->sort->hasAttribute($cell['attribute'])
              //  ? $provider->sort->attributes[$cell['attribute']] : false;
        }

       // var_dump($data['columns']);

        return [
            'columns' => $data['columns'],
            'data' => $rows ?? [],
            'pagination' => $pagination,
            'sort' => $sort ?? null,
            'direction' => $direction ?? null
        ];
    }

    public static function dataRequest($params) {
        return json_encode(static::getData([
            'query' => $params['query'],
            'columns' => $params['columns'],
            'curPage' => $params['post']['curPage'] ?? null,
            'sort' => $params['post']['sort'] ?? null,
            'direction' => $params['post']['direction'] ?? null,
            'filter' => $params['post']['filter'] ?? null,
            'limit' =>$params['post']['limit'] ?? null
        ]));
    }


    public static function getArrayData($data) {
        $limit = $data['limit'] ?? static::DEFAULT_LIMIT;
        $curPage = $data['curPage'] ?? 1;

        /** @var $rowData[] */
        $rowData = $data['query'];

        $data['filter'] = json_decode($data['filter'], 1);
        if (isset($data['filter'])) {
            foreach ($data['filter'] as $attr => $value) {
//                $query = $query->where([$attr => $value]);
            }
        }

        $totalCount = count($rowData);

        $pagination = [
            'pageCount' => ceil($totalCount / $limit),
            'curPage' => (int)$curPage,
            'offset' => $limit * ($curPage - 1),
            'totalCount' => (int)$totalCount,
            'limit' => (int)$limit
        ];

        if ($curPage > $pagination['pageCount']) {
            $pagination['curPage'] = 1;
            $pagination['offset'] = 0;
        }

        if ($totalCount > 0) {
            $data['columns'][] = [
                'attribute' => 'id',
                'visible' => false
            ];

            // либо указанную сортировку применяем, или же коли нет её - по умолчанию
            $sort = $data['sort'] ?? null;
            $direction = $data['direction'] ?? null;

            if (isset($sort)) {
                $query = $query->addOrderBy($sort . ' ' . $direction);

            } else {
                //$provider->sort->setAttributeOrders($defaultOrder = $provider->sort->defaultOrder);
                //$query = $query->addOrderBy($defaultOrder);
                //$sort = $sort ?? (key($defaultOrder));
                $direction = 'asc';
            }

            $query = $query->limit($limit)->offset($pagination['offset']);

            if (isset($data['filter'])) {
                foreach ($data['filter'] as $attr => $value) {
                    $query = $query->where([$attr => $value]);
                }
            }

            $result = $query->asArray()->all();

            $rows = [];

            foreach ($result as $pkey => $row) {
                $rowData = [];
                foreach ($data['columns'] as $key => $cell) {
                    $attrName = $cell['attribute'] ?? null;
                    $closure = $cell['value'] ?? null;

                    if (is_callable($closure)) {
                        $rowData[$attrName]['value'] = $closure($row);
                    } else {
                        $rowData[$attrName]['value'] = $row[$attrName] ?? null;
                    }

                    $rowData[$attrName]['val'] = $rowData[$attrName] ?? null;
                }
                $rows[] = $rowData;
            }
        }

        foreach ($data['columns'] as $key => &$cell) {
            $cell['visible'] = $cell['visible'] ?? true;
            $cell['label'] = $cell['label'] ?? (isset($cell['attribute']) && $cell['attribute'] ? $query->getModelClass()::getLabel($cell['attribute']) : '');
            $cell['sort'] = 'id'; // isset($cell['attribute']) && $provider->sort->hasAttribute($cell['attribute'])
            //  ? $provider->sort->attributes[$cell['attribute']] : false;
        }

        // var_dump($data['columns']);

        return [
            'columns' => $data['columns'],
            'data' => $rows ?? [],
            'pagination' => $pagination,
            'sort' => $sort ?? null,
            'direction' => $direction ?? null
        ];
    }

    public static function arrayDataRequest($params) {
        return json_encode(static::getArrayData([
            'data' => $params['data'],
            'columns' => $params['columns'],
            'curPage' => $params['post']['curPage'] ?? null,
            'sort' => $params['post']['sort'] ?? null,
            'direction' => $params['post']['direction'] ?? null,
            'filter' => $params['post']['filter'] ?? null,
            'limit' =>$params['post']['limit'] ?? null
        ]));
    }

}
