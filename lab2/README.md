Content Creators

Part 1: Semantic HTML

  In the part1 HTML file, we chose <section> tags to separate each song entry. Within each <section>, different
  parts of the song's information, such as "Track Name" and "Artist", are marked up as list items <li> of an unordered list <ul>.
  Album images are marked up as <img> with a fixed universal size.

  In this way, ten different songs are ordered with identical format and semantic tags, and HTML file is logically structured and understandable.

Part 2: XML
  After declaring XML root element, we chose <playlist_10_favorite_songs> tag to be the elementary level of XML hierarchy. Within this
  level, each song entry is enclosed by <song> tags, and all parts of the song information are enclosed by <track>, <artist>, <album>, <release_date>, and <genres>, in parallel.


Part 3: HTML & CSS

  Following the logic from part 1, we chose to use <section> tag for each song entry, but within the section, we used logical division tags <div> with specified class names for each piece of song information. Names used for them correspond with tag names we used in XML, such as "track", "album", and etc. We assumed the instructions "the title of your favorite song should appear in green" meant every song title would appear in green because these are all our favorite songs.

Part 4: XML & CSS

  In the part4 XML file, we labeled all tags according to the information they held (i.e., <track> holds the track name, <song> holds all information about a particular song, etc.). In order to use hyperlinks and images in our XML file, our team added the html namespace at the beginning of the document. Our team also referenced an external CSS file at the beginning of the document, which enabled us to display the XML file neatly in our browser.
  We assumed that the directions "Edit the stylesheet such that the information should be displayed with each item on a separate line" meant all information about a particular song is displayed on the same line, with each separate song having a separate line.
