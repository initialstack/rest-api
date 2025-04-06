<?php declare(strict_types=1);

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

final class Paginator extends LengthAwarePaginator
{
    /**
     * The current request instance.
     *
     * @var \Illuminate\Support\Facades\Request
     */
    private readonly Request $request;

    /**
     * Constructs a new paginator instance.
     *
     * @param array $items
     * @param int $perPage
     */
    public function __construct(array $items, int $perPage = 11)
    {
        /*
         * Initialize the request instance.
         */
        $this->request = new Request();

        /*
         * Call the parent constructor with paginated items and request data.
         */
        parent::__construct(
            items: $this->items(items: $items, perPage: $perPage),
            total: count(value: $items),
            perPage: $perPage,
            currentPage: $this->request->get(
                key: 'page',
                default: 1
            ),
            options: [
                'path' => $this->request->url(),
                'query' => $this->request->query()
            ]
        );
    }

    /**
     * Returns a slice of items for the current page.
     *
     * @param array $items
     * @param int $perPage
     * 
     * @return array
     */
    private function items(array $items, int $perPage): array
    {
        /*
         * Determine the current page from the request.
         */
        $currentPage = $this->request->get(key: 'page', default: 1);

        /*
         * Slice the items array based on the current page and per page count.
         */
        return collect(value: $items)->slice(
            offset: ($currentPage - 1) * $perPage,
            length: $perPage
        )->all();
    }
}
