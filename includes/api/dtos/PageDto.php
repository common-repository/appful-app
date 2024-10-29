<?php

namespace AppfulPlugin\Api\Dtos;

class PageDto {
	public int $id = - 1;
	public string $title = "";
	public string $url = "";
	public ?UserDto $author = null;
	public ?AttachmentDto $thumbnail = null;
	public string $status = "";
	public string $language = "";
	public string $modified = "";
	public string $date = "";
	public string $comment_status = "";
	/** @var RoleDto[] */
	public array $roles = [];

	/**
	 * @param RoleDto[] $roles
	 */
	public function __construct(
		int $id,
		string $title,
		string $url,
		?UserDto $author,
		?AttachmentDto $thumbnail,
		string $status,
		string $language,
		string $modified,
		string $date,
		string $comment_status,
		array $roles
	) {
		$this->id             = $id;
		$this->title          = $title;
		$this->url            = $url;
		$this->author         = $author;
		$this->thumbnail      = $thumbnail;
		$this->status         = $status;
		$this->language       = $language;
		$this->modified       = $modified;
		$this->date           = $date;
		$this->comment_status = $comment_status;
		$this->roles          = $roles;
	}
}
