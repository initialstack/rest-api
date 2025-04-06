<?php declare(strict_types=1);

namespace App\Modules\Account\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Entities\Media;

final class ShowUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'avatars' => $this->getMedia()->isEmpty() ? null : array_map(
                callback: function (Media $media): array {
                    return [
                        'id' => $media->getId(),
                        'file_path' => Storage::url(path: $media->getFilePath()),
                        'datetime' => [
                            'created_at' => $media->getCreatedAt()->format(
                                format: 'Y-m-d H:i:s'
                            ),
                            'updated_at' => $media->getUpdatedAt()->format(
                                format: 'Y-m-d H:i:s'
                            ),
                        ],
                    ];
                },
                array: $this->getMedia()->toArray()
            ),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'patronymic' => $this->getPatronymic(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'email_verified_at' => $this->getEmailVerifiedAt()?->format(
                format: 'Y-m-d'
            ),
            'status' => $this->getStatus(),
            'role' => $this->getRole() ? [
                'id' => $this->getRole()->getId(),
                'name' => $this->getRole()->getName(),
                'slug' => $this->getRole()->getSlug(),
                'datetime' => [
                    'created_at' => $this->getRole()->getCreatedAt()->format(
                        format: 'Y-m-d H:i:s'
                    ),
                    'updated_at' => $this->getRole()->getUpdatedAt()->format(
                        format: 'Y-m-d H:i:s'
                    ),
                ],
            ] : null,
            'datetime' => [
                'created_at' => $this->getCreatedAt()->format(
                    format: 'Y-m-d H:i:s'
                ),
                'updated_at' => $this->getUpdatedAt()->format(
                    format: 'Y-m-d H:i:s'
                ),
            ],
        ];
    }
}
