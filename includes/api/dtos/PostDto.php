<?php

namespace AppfulPlugin\Api\Dtos;

class PostDto {
	public int $id = - 1;
	public string $title = "";
	public string $url = "";
	public ?UserDto $author = null;
	/** @var CategoryDto[] */
	public array $categories = [];
	/** @var TagDto[] */
	public array $tags = [];
	public ?AttachmentDto $thumbnail = null;
	/** @var AttachmentDto[] */
	public array $attachments = [];
	public string $status = "";
	public string $language = "";
	public string $modified = "";
	public string $date = "";
	public string $comment_status = "";
	public bool $sticky = false;
	public bool $send_push = false;
	/** @var RoleDto[] */
	public array $roles = [];

	/**
	 * @param CategoryDto[] $categories
	 * @param TagDto[] $tags
	 * @param AttachmentDto[] $attachments
	 * @param RoleDto[] $roles
	 */
	public function __construct(
		int $id,
		string $title,
		string $url,
		?UserDto $author,
		array $categories,
		array $tags,
		?AttachmentDto $thumbnail,
		array $attachments,
		string $status,
		string $language,
		string $modified,
		string $date,
		string $comment_status,
		bool $sticky,
		bool $send_push,
		array $roles
	) {
		$this->id             = $id;
		$this->title          = $title;
		$this->url            = $url;
		$this->author         = $author;
		$this->categories     = $categories;
		$this->tags           = $tags;
		$this->thumbnail      = $thumbnail;
		$this->attachments    = $attachments;
		$this->status         = $status;
		$this->language       = $language;
		$this->modified       = $modified;
		$this->date           = $date;
		$this->comment_status = $comment_status;
		$this->sticky         = $sticky;
		$this->send_push      = $send_push;
		$this->roles        = $roles;
	}
}