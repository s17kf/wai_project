<?php

const GALLERY_IMAGE_MAX_SIZE = 1000000;

const GALLERY_ACCEPTED_FILE_TYPES = ['image/jpeg', 'image/png'];

const GALLERY_FILETYPE_TO_EXTENSION = [
  'image/jpeg' => 'jpg',
  'image/png' => 'png',
];

const GALLERY_EXPECTED_EXTENSIONS = ['jpg', 'jpeg', 'png'];

const MAX_SAME_NAME_FILES = 100;

const IMAGES_PER_PAGE = 7;

const IMAGES_DIRS = [
  'full' => 'images/full_size',
  'mini' => 'images/thumbnails',
  'watermarked' => 'images/watermarked',
];
