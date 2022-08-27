<?php

namespace App\Class;

class Pagination
{
    public function paginationLinks(string $link, int $page): array
    {
        if (!isset($_SERVER['QUERY_STRING']) || strlen($_SERVER['QUERY_STRING']) === 0) {
            $previousLink = $link;
            if ($page > 2) {
                $previousLink = $link . '?page=' . ($page - 1);
            }
            $nextLink = $link . '?page=' . $page + 1;
        } else {
            if (isset($_GET['page'])) {
                if (strpos($_SERVER['QUERY_STRING'], '&')) {
                    $previousLink = $link . '?' . substr($_SERVER['QUERY_STRING'], strpos($_SERVER['QUERY_STRING'], '&') + 1);
                } else {
                    $previousLink = $link;
                }
                if ($page > 2) {
                    $previousLink = $link . '?page=' . ($page - 1) . stristr($_SERVER['QUERY_STRING'], '&');
                }
                $nextLink = $link . '?page=' . $page + 1 . stristr($_SERVER['QUERY_STRING'], '&');
            } else {
                $previousLink = $link . '&' . $_SERVER['QUERY_STRING'];
                if ($page > 2) {
                    $previousLink = $link . '?page=' . ($page - 1) . '&' . $_SERVER['QUERY_STRING'];
                }   
                $nextLink = $link . '?page=' . $page + 1 . '&' . $_SERVER['QUERY_STRING'];
            }
        }

        return [
            'previousLink' => $previousLink,
            'nextLink' => $nextLink
        ];
    }
}