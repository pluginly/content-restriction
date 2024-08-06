import { __ } from '@wordpress/i18n';

export default function ModifiedTime( { timestamp } ) {
	let jsTime = timestamp * 1000;
	const relativeTime = getRelativeTime(jsTime);
	return relativeTime;
}

const getRelativeTime = (timestamp) => {
    const now = new Date();
    const date = new Date(timestamp);
    const seconds = Math.floor((now - date) / 1000);
  
    let interval = Math.floor(seconds / 31536000);
    if (interval >= 1) {
      return interval === 1 ? __( " 1 year ago", 'content-restriction' ) : interval + __( " years ago", 'content-restriction' );
    }
    interval = Math.floor(seconds / 2592000);
    if (interval >= 1) {
      return interval === 1 ? __( " 1 month ago", 'content-restriction' ) : interval + __( " months ago", 'content-restriction' );
    }
    interval = Math.floor(seconds / 86400);
    if (interval >= 1) {
      return interval === 1 ? __( " 1 day ago", 'content-restriction' ) : interval + __( " days ago", 'content-restriction' );
    }
    interval = Math.floor(seconds / 3600);
    if (interval >= 1) {
      return interval === 1 ? __( " 1 hour ago", 'content-restriction' ) : interval +  __( " hours ago", 'content-restriction' );
    }
    interval = Math.floor(seconds / 60);
    if (interval >= 1) {
      return interval === 1 ? __( " 1 minute ago", 'content-restriction' ) : interval + __( " minutes ago", 'content-restriction' );
    }
    return Math.floor(seconds) === 1 ? __( " 1 second ago", 'content-restriction' ) : Math.floor(seconds) + __( " seconds ago", 'content-restriction' );
};