<?php
$post = get_post();

$activitypub_post = new Activitypub_Post( $post );
$activitypub_activity = new Activitypub_Activity( 'Create', Activitypub_Activity::TYPE_FULL );
$activitypub_activity->from_post( $activitypub_post->to_array() );

// filter output
$json = apply_filters( 'activitypub_json_post_array', $activitypub_activity->to_array() );

/*
 * Action triggerd prior to the ActivityPub profile being created and sent to the client
 */
do_action( 'activitypub_json_post_pre' );

$options = 0;
// JSON_PRETTY_PRINT added in PHP 5.4
if ( get_query_var( 'pretty' ) ) {
	$options |= JSON_PRETTY_PRINT; // phpcs:ignore
}

$options |= JSON_UNESCAPED_UNICODE;

/*
 * Options to be passed to json_encode()
 *
 * @param int $options The current options flags
 */
$options = apply_filters( 'activitypub_json_post_options', $options );

header( 'Content-Type: application/activity+json' );
echo wp_json_encode( $json, $options );

/*
 * Action triggerd after the ActivityPub profile has been created and sent to the client
 */
do_action( 'activitypub_json_post_post' );
