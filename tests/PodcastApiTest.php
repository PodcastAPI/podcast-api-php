<?php

namespace ListenNotes\PodcastApi;

use PHPUnit\Framework\TestCase;

class PodcastApiTest extends TestCase
{
    protected $podcastApiClient;

    protected function setUp(): void
    {
        $this->podcastApiClient = new Client();
    }

    public function testIsInstanceOfPodcastApiClient(): void
    {
        $actual = $this->podcastApiClient;
        $this->assertInstanceOf(Client::class, $actual);
    }

    public function testSetApiKey(): void
    {
        $objClient = $this->podcastApiClient;
        $this->assertSame( $objClient->getRequestHeader( 'X-ListenAPI-Key' ), null );

        $strKey = 'testKey';
        $objClient = new Client( $strKey );
        $this->assertSame( $objClient->getRequestHeader( 'X-ListenAPI-Key' ), $strKey );
    }

    public function testSearchWithMock(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'sort_by_date' => '1', 'q' => 'dummy' ];
        $strResponse = $objClient->search( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'results'));
        $this->assertGreaterThan( 0, count( $objResponse->results ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/search' );
        parse_str( $arrUrl['query'], $arrQuery );
        $this->assertSame( $arrQuery['q'], $arrOptions['q'] );
        $this->assertSame( $arrQuery['sort_by_date'], $arrOptions['sort_by_date'] );
    }

    public function testSearchWithAuthenticationError(): void
    {
        $strKey = 'testKey';
        $objClient = new Client( $strKey );
        try {
            $objClient->search( [ 'q' => 'dummy' ] );
            $this->fail( 'Did not throw an exception.' );
        } catch ( Exception\AuthenticationException $objException ) {
            $this->assertSame( $objClient->getStatusCode(), Exception\AuthenticationException::STATUS );
        } catch ( \Exception $objException ) {
            $this->fail( 'Wrong type of exception thrown.' );
        }
    }

    public function testTypeahead(): void
    {
        $objClient = $this->podcastApiClient;
        $strTerm = 'dummy';
        $arrOptions = [ 'show_podcasts' => '1', 'q' => 'dummy' ];
        $strResponse = $objClient->typeahead( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'terms'));
        $this->assertGreaterThan( 0, count( $objResponse->terms ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/typeahead' );
        parse_str( $arrUrl['query'], $arrQuery );
        $this->assertSame( $arrQuery['q'], $arrOptions['q'] );
        $this->assertSame( $arrQuery['show_podcasts'], $arrOptions['show_podcasts'] );
    }

    public function testSpellcheck(): void
    {
        $objClient = $this->podcastApiClient;
        $strTerm = 'dummy';
        $arrOptions = [ 'q' => 'dummy' ];
        $strResponse = $objClient->spellcheck( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'tokens'));        
        $this->assertGreaterThan( 0, count( $objResponse->tokens ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/spellcheck' );
        parse_str( $arrUrl['query'], $arrQuery );
        $this->assertSame( $arrQuery['q'], $arrOptions['q'] );
    }    

    public function testFetchRelatedSearches(): void
    {
        $objClient = $this->podcastApiClient;
        $strTerm = 'dummy';
        $arrOptions = [ 'q' => 'dummy' ];
        $strResponse = $objClient->fetchRelatedSearches( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'terms'));
        $this->assertGreaterThan( 0, count( $objResponse->terms ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/related_searches' );
        parse_str( $arrUrl['query'], $arrQuery );
        $this->assertSame( $arrQuery['q'], $arrOptions['q'] );
    }        


    public function testFetchTrendingSearches(): void
    {
        $objClient = $this->podcastApiClient;
        $strResponse = $objClient->fetchTrendingSearches();
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'terms'));
        $this->assertGreaterThan( 0, count( $objResponse->terms ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/trending_searches' );
    }  

    public function testFetchBestPodcasts(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'genre_id' => '23' ];
        $strResponse = $objClient->fetchBestPodcasts( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'total'));
        $this->assertGreaterThan( 0, $objResponse->total );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/best_podcasts' );
        parse_str( $arrUrl['query'], $arrQuery );
        $this->assertSame( $arrQuery['genre_id'], $arrOptions['genre_id'] );
    }

    public function testFetchPodcastById(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'id' => 'shkjhd' ];
        $strResponse = $objClient->fetchPodcastById( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'episodes'));        
        $this->assertGreaterThan( 0, count( $objResponse->episodes ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/podcasts/' . $arrOptions['id'] );
    }

    public function testFetchEpisodesById(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'id' => 'shkjhd' ];
        $strResponse = $objClient->fetchEpisodeById( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'podcast'));   
        $this->assertGreaterThan( 0, strlen( $objResponse->podcast->rss ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/episodes/' . $arrOptions['id'] );
    }

    public function testFetchCuratedPodcastsListById(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'id' => 'shkjhd' ];
        $strResponse = $objClient->fetchCuratedPodcastsListById( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'podcasts'));   
        $this->assertGreaterThan( 0, count( $objResponse->podcasts ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/curated_podcasts/' . $arrOptions['id'] );
    }

    public function testFetchCuratedPodcastsLists(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'page' => '3' ];
        $strResponse = $objClient->fetchCuratedPodcastsLists( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'curated_lists')); 
        $this->assertGreaterThan( 0, count( $objResponse->curated_lists ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/curated_podcasts' );
        parse_str( $arrUrl['query'], $arrQuery );        
        $this->assertSame( $arrQuery['page'], $arrOptions['page'] );        
    }    

    public function testBatchFetchPodcasts(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'ids' => '996,777,888,1000' ];
        $strResponse = $objClient->batchFetchPodcasts( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'podcasts'));
        $this->assertGreaterThan( 0, count( $objResponse->podcasts ) );
        $this->assertSame( $objClient->getMethod(), 'POST' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/podcasts' );

        parse_str( urldecode( $objClient->getRequestBody() ), $arrQuery );
        $this->assertSame( $arrQuery['ids'], $arrOptions['ids'] );

        $arrHeaders = $objClient->parseRequestHeaders();
        $this->assertSame( $arrHeaders['content-type'], 'application/x-www-form-urlencoded' );
    }

    public function testBatchFetchEpisodes(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'ids' => '996,777,888,1000' ];
        $strResponse = $objClient->batchFetchEpisodes( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'episodes'));
        $this->assertGreaterThan( 0, count( $objResponse->episodes ) );
        $this->assertSame( $objClient->getMethod(), 'POST' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/episodes' );

        parse_str( urldecode( $objClient->getRequestBody() ), $arrQuery );
        $this->assertSame( $arrQuery['ids'], $arrOptions['ids'] );

        $arrHeaders = $objClient->parseRequestHeaders();
        $this->assertSame( $arrHeaders['content-type'], 'application/x-www-form-urlencoded' );
    }

    public function testFetchPodcastGenres(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'top_level_only' => '1' ];
        $strResponse = $objClient->fetchPodcastGenres( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'genres'));
        $this->assertGreaterThan( 0, count( $objResponse->genres ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/genres' );
        parse_str( $arrUrl['query'], $arrQuery );
        $this->assertSame( $arrQuery['top_level_only'], $arrOptions['top_level_only'] );
    }

    public function testFetchPodcastRegions(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ ];
        $strResponse = $objClient->fetchPodcastRegions( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'regions'));        
        $this->assertGreaterThan( 0, count( (array) $objResponse->regions ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/regions' );
    }

    public function testFetchPodcastLanguages(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ ];
        $strResponse = $objClient->fetchPodcastLanguages( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'languages'));
        $this->assertGreaterThan( 0, count( $objResponse->languages ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/languages' );
    }

    public function testJustListen(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ ];
        $strResponse = $objClient->justListen( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'audio_length_sec'));
        $this->assertGreaterThan( 0, $objResponse->audio_length_sec );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/just_listen' );
    }

    public function testFetchRecommendationsForPodcast(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'id' => 'shkjhd' ];
        $strResponse = $objClient->fetchRecommendationsForPodcast( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'recommendations'));
        $this->assertGreaterThan( 0, count( $objResponse->recommendations ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/podcasts/' . $arrOptions['id'] . '/recommendations' );
    }

    public function testFetchRecommendationsForEpisode(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'id' => 'shkjhd' ];
        $strResponse = $objClient->fetchRecommendationsForEpisode( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'recommendations'));
        $this->assertGreaterThan( 0, count( $objResponse->recommendations ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/episodes/' . $arrOptions['id'] . '/recommendations' );
    }

    public function testFetchPlaylistById(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'id' => 'shkjhd' ];
        $strResponse = $objClient->fetchPlaylistById( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'items'));        
        $this->assertGreaterThan( 0, count( $objResponse->items ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/playlists/' . $arrOptions['id'] );
    }

    public function testFetchMyPlaylists(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'page' => '2' ];
        $strResponse = $objClient->fetchMyPlaylists( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'playlists'));
        $this->assertGreaterThan( 0, count( $objResponse->playlists ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/playlists' );
    }

    public function testSumbitPodcast(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'rss' => 'http://myrss.com/rss' ];
        $strResponse = $objClient->submitPodcast( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'status'));
        $this->assertGreaterThan( 0, strlen( $objResponse->status ) );
        $this->assertSame( $objClient->getMethod(), 'POST' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/podcasts/submit' );

        parse_str( urldecode( $objClient->getRequestBody() ), $arrQuery );
        $this->assertSame( $arrQuery['rss'], $arrOptions['rss'] );

        $arrHeaders = $objClient->parseRequestHeaders();
        $this->assertSame( $arrHeaders['content-type'], 'application/x-www-form-urlencoded' );
    }

    public function testDeletePodcast(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'id' => '11111' ];
        $strResponse = $objClient->deletePodcast( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'status'));
        $this->assertGreaterThan( 0, strlen( $objResponse->status ) );
        $this->assertSame( $objClient->getMethod(), 'DELETE' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/podcasts/' . $arrOptions['id'] );
    }

    public function testFetchAudienceForPodcast(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'id' => 'shkjhd' ];
        $strResponse = $objClient->fetchAudienceForPodcast( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'by_regions'));
        $this->assertGreaterThan( 0, count( $objResponse->by_regions ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/podcasts/' . $arrOptions['id'] . '/audience' );
    }
    
    public function testFetchPodcastsByDomain(): void
    {
        $objClient = $this->podcastApiClient;
        $arrOptions = [ 'domain_name' => 'npr.org' ];
        $strResponse = $objClient->fetchPodcastsByDomain( $arrOptions );
        $objResponse = json_decode( $strResponse );

        $this->assertTrue(property_exists($objResponse, 'podcasts'));
        $this->assertGreaterThan( 0, count( $objResponse->podcasts ) );
        $this->assertSame( $objClient->getMethod(), 'GET' );
        $arrUrl = parse_url( $objClient->getUri() );
        $this->assertSame( $arrUrl['path'], '/api/v2/podcasts/domains/' . $arrOptions['domain_name'] );
    }    
}
