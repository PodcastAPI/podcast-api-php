<?php

namespace ListenNotes\PodcastApiClient\Exception;

class NotFoundException extends ListenApiException
{
    const STATUS = 404;
    // Endpoint not exist or the podcast / episode not exist
}
