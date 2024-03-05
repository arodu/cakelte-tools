<?php

declare(strict_types=1);

namespace CakeLteTools\Controller\Traits;

use Cake\Utility\Hash;

trait ExportDataTrait
{
    /**
     * @param array $data
     * @param array $fields
     * @param array $options
     * @return \Cake\Http\Response|null
     */
    protected function exportCsv(array $data, array $fields, array $options = []): ?Response
    {
        $results = array_map(function ($row) use ($fields) {
            $result = [];
            foreach ($fields as $key => $field) {
                if (!is_numeric($key)) {
                    $field = $key;
                }

                $result[] = Hash::get($row, $field);
            }
            return $result;
        }, $data);

        $results = array_merge([$fields], $results);

        return $this->response
            ->withType('csv')
            ->withDownload($options['filename'] ?? 'export.csv')
            ->withStringBody($this->arrayToCsv($results));
    }

    /**
     * @param array $data
     * @return string|false
     */
    protected function arrayToCsv(array $data): string|false
    {
        $output = fopen('php://memory', 'w');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        rewind($output);

        return stream_get_contents($output);
    }

    /**
     * @param string $name
     * @param string $ext
     * @return string
     */
    protected function filenameWithDate(string $name, string $ext = 'csv'): string
    {
        return sprintf('%s_%s.%s', $name, date('YmdHis'), $ext);
    }
}
