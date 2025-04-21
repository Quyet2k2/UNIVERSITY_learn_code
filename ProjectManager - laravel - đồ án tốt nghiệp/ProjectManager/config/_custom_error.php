<?php
return [
  '404' => [
    'code' => 404,
    'title' => 'Page not found!',
    'message' => 'Page does not exist.',
  ],
  '500' => [
    'code' => 500,
    'title' => 'Internal server error!',
    'message' => 'Something went wrong.',
  ],
  '403' => [
    'code' => 403,
    'title' => 'Forbidden!',
    'message' => 'You do not have permission to access this page.',
  ],
  '401' => [
    'code' => 401,
    'title' => 'Unauthorized!',
    'message' => 'You are not authorized to access this page.',
  ],
  '419' => [
    'code' => 419,
    'title' => 'Page expired!',
    'message' => 'The page has expired. Please try again.',
  ],
  '429' => [
    'code' => 429,
    'title' => 'Too many requests!',
    'message' => 'You have made too many requests. Please try again later.',
  ],
  '503' => [
    'code' => 503,
    'title' => 'Service unavailable!',
    'message' => 'The service is temporarily unavailable. Please try again later.',
  ],
  '502' => [
    'code' => 502,
    'title' => 'Bad gateway!',
    'message' => 'The server encountered an internal error. Please try again later.',
  ],
  '504' => [
    'code' => 504,
    'title' => 'Gateway timeout!',
    'message' => 'The server took too long to respond. Please try again later.',
  ],
];