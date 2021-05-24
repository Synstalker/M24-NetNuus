'use strict';

/**
 * Determine the mobile operating system.
 * This function returns one of 'iOS', 'Android', 'Windows Phone', or 'unknown'.
 * @see https://stackoverflow.com/a/21742107/1654250
 *
 * @returns {String}
 */
var  MoonBoy = 'undefined' === typeof MoonBoy ? {} : MoonBoy;
MoonBoy = Object.assign( MoonBoy, {
  util: {
    device: {
      OS: {
        ANDROID: 'Android',
        iOS: 'iOS',
        WINDOWS_PHONE: 'Windows Phone',
        UNKNOWN: 'unknown'
      },
      getOS: function() {
        let userAgent = navigator.userAgent || navigator.vendor || window.opera;

        // Windows Phone must come first because its UA also contains "Android"
        if ( /windows phone/i.test( userAgent ) ) {
          return MoonBoy.util.device.OS.WINDOWS_PHONE;
        }

        if ( /android/i.test( userAgent ) ) {
          return MoonBoy.util.device.OS.ANDROID;
        }

        // iOS detection from: http://stackoverflow.com/a/9039885/177710
        if ( /iPad|iPhone|iPod/.test( userAgent ) && ! window.MSStream ) {
          return MoonBoy.util.device.OS.iOS;
        }

        return MoonBoy.util.device.OS.UNKNOWN;
      },
      isAndroid: function() {
        return MoonBoy.util.device.OS.ANDROID === MoonBoy.util.device.getOS();
      },
      isiOS: function() {
        return MoonBoy.util.device.OS.iOS === MoonBoy.util.device.getOS();
      }
    }
  }
});

( function( $ ) {

  /**
   * Hide irrelevant os button when on mobile
   * @todo, make this more generic, i.e. a class, e.g hide_on_android, hide_on_ios
   */
  if ( MoonBoy.util.device.isAndroid() ) {
    $( '.buttons .ios' ).hide();
    $( '.phone img' ).attr( 'src', '/wp-content/themes/moon-boy/assets/images/defaults/phone-android.png' );
  } else if ( MoonBoy.util.device.isiOS() ) {
    $( '.buttons .android' ).hide();
  }

  window.blockMenuHeaderScroll = false;

  $( window ).on( 'touchend', function() {
    window.blockMenuHeaderScroll = false;
  });
  $( window ).on( 'touchmove', function( e ) {
    if ( blockMenuHeaderScroll ) {
      e.preventDefault();
    }
  });

  /**
   * Scroll indicator hide / show logic
   */
  window.scrollInidicatorTimeout = false;
  let $feedIndicator = $( '.feed-container .mouse' );
  $feedIndicator.on( 'touchstart', function( e ) {
    window.blockMenuHeaderScroll = true;
    e.preventDefault();
    clearTimeout( window.scrollInidicatorTimeout );
    $( '.feed-container .mouse' ).hide();
    let $feedElementTwo = $( '#feed' );
    $feedElementTwo.focus();
    if ( 10 > $feedElementTwo.scrollTop() ) {
      $feedElementTwo.animate({
        scrollTop: 150
      });
    }
  });

  $feedIndicator.on( 'touchend', function() {
    window.scrollInidicatorTimeout = setTimeout( function() {
      $( '.feed-container .mouse' ).show();
    }, 3000 );
  });

  window.feedPS = null;
  if ( 1 > ! document.querySelectorAll( '.feed' ).length ) {
    window.feedPS = new PerfectScrollbar( '.feed' );

    let $feedElement = $( '.feed' );
    $feedElement.on( 'ps-scroll-up', function() {
      $( this ).removeClass( 'ps-bottom' );
    });

    $feedElement.on( 'ps-scroll-down', function() {
      if ( 90 < ( window.feedPS.scrollbarYTop /
          ( feedPS.containerHeight - feedPS.scrollbarYHeight ) ) * 100 ) {
        $( this ).addClass( 'ps-bottom' );
      }
    });

    $feedElement.on( 'ps-y-reach-end', function() {
      $( this ).addClass( 'ps-bottom' );
    });
  }
}( jQuery ) );
