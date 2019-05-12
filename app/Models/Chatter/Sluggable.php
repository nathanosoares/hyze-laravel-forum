<?php


namespace App\Models\Chatter;


use Illuminate\Support\Collection;

interface Sluggable
{

    public function getId();

    public function getDisplayName(): string;

    public function getDescription(): ?string;

    public function getRoute(): string;

    public function getChildren(): Collection;
}