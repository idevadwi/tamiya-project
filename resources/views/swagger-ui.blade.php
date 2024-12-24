<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Swagger UI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.11.1/swagger-ui.css" />
</head>
<body>
<div id="swagger-ui"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.11.1/swagger-ui-bundle.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const ui = SwaggerUIBundle({
            url: '/docs/swagger.json', // Path to your OpenAPI file
            dom_id: '#swagger-ui',
            requestInterceptor: (req) => {
                req.headers['X-CSRF-TOKEN'] = csrfToken; // Add CSRF token to request headers
                return req;
            },
        });
    });
</script>
</body>
</html>
