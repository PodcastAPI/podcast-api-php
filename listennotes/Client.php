<?php

declare(strict_types=1);

namespace ListenNotes\PodcastApi;

final class Client extends Http\Curl
{
    public function __construct( $strApiKey = '' )
    {
        parent::__construct( $strApiKey );
    }

    public function fetchMyPlaylists( array $arrOptions = [] )
    {
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'playlists' ) . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function justListen( array $arrOptions = [] )
    {
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'just_listen' ) . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchPodcastLanguages( array $arrOptions = [] )
    {
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'languages' ) . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchPodcastRegions( array $arrOptions = [] )
    {
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'regions' ) . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchPodcastGenres( array $arrOptions = [] )
    {
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'genres' ) . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchCuratedPodcastsLists( array $arrOptions = [] )
    {
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'curated_podcasts' ) . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchRecommendationsForEpisode( array $arrOptions = [] )
    {
        $strId = null;
        if ( isset( $arrOptions['id'] ) ) {
            $strId = $arrOptions['id'];
            unset( $arrOptions['id'] );
        }
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'episodes' ) . '/' . $strId . '/recommendations' . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchRecommendationsForPodcast( array $arrOptions = [] )
    {
        $strId = null;
        if ( isset( $arrOptions['id'] ) ) {
            $strId = $arrOptions['id'];
            unset( $arrOptions['id'] );
        }
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'podcasts' ) . '/' . $strId . '/recommendations' . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchPlaylistById( array $arrOptions = [] )
    {
        $strId = null;
        if ( isset( $arrOptions['id'] ) ) {
            $strId = $arrOptions['id'];
            unset( $arrOptions['id'] );
        }
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'playlists' ) . '/' . $strId . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchCuratedPodcastsListById( array $arrOptions = [] )
    {
        $strId = null;
        if ( isset( $arrOptions['id'] ) ) {
            $strId = $arrOptions['id'];
            unset( $arrOptions['id'] );
        }
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'curated_podcasts' ) . '/' . $strId . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchEpisodeById( array $arrOptions = [] )
    {
        $strId = null;
        if ( isset( $arrOptions['id'] ) ) {
            $strId = $arrOptions['id'];
            unset( $arrOptions['id'] );
        }
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'episodes' ) . '/' . $strId . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchPodcastById( array $arrOptions = [] )
    {
        $strId = null;
        if ( isset( $arrOptions['id'] ) ) {
            $strId = $arrOptions['id'];
            unset( $arrOptions['id'] );
        }
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'podcasts' ) . '/' . $strId . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function batchFetchEpisodes( array $arrOptions = [] )
    {
        $strUrl = $this->getAction( 'episodes' );
        $strResponse = $this->post( $strUrl, $arrOptions );
        return $strResponse;
    }

    public function batchFetchPodcasts( array $arrOptions = [] )
    {
        $strUrl = $this->getAction( 'podcasts' );
        $strResponse = $this->post( $strUrl, $arrOptions );
        return $strResponse;
    }

    public function submitPodcast( array $arrOptions = [] )
    {
        $strUrl = $this->getAction( 'podcasts/submit' );
        $strResponse = $this->post( $strUrl, $arrOptions );
        return $strResponse;
    }

    public function deletePodcast( array $arrOptions = [] )
    {
        $strId = null;
        if ( isset( $arrOptions['id'] ) ) {
            $strId = $arrOptions['id'];
            unset( $arrOptions['id'] );
        }
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'podcasts' ) . '/' . $strId;
        $strResponse = $this->delete( $strUrl, $arrOptions );
        return $strResponse;
    }

    public function fetchBestPodcasts( array $arrOptions = [] )
    {
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'best_podcasts' ) . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchRelatedSearches( array $arrOptions = [] )
    {
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'related_searches' ) . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchTrendingSearches( array $arrOptions = [] )
    {
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'trending_searches' ) . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }    

    public function spellcheck( array $arrOptions = [] )
    {
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'spellcheck' ) . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function typeahead( array $arrOptions = [] )
    {
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'typeahead' ) . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }    

    public function search( array $arrOptions = [] )
    {
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'search' ) . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchAudienceForPodcast( array $arrOptions = [] )
    {
        $strId = null;
        if ( isset( $arrOptions['id'] ) ) {
            $strId = $arrOptions['id'];
            unset( $arrOptions['id'] );
        }
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'podcasts' ) . '/' . $strId . '/audience' . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }

    public function fetchPodcastsByDomain( array $arrOptions = [] )
    {
        $strDomainName = null;
        if ( isset( $arrOptions['domain_name'] ) ) {
            $strDomainName = $arrOptions['domain_name'];
            unset( $arrOptions['domain_name'] );
        }
        $strQuery = count( $arrOptions ) ? '?' . http_build_query( $arrOptions ) : '';
        $strUrl = $this->getAction( 'podcasts' ) . '/domains/' . $strDomainName . $strQuery;
        $strResponse = $this->get( $strUrl );
        return $strResponse;
    }        
}
