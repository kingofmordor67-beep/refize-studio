export default {
    name: 'news',
    title: 'News',
    type: 'document',
    fields: [
        {
            name: 'title',
            title: 'Title',
            type: 'string',
        },
        {
            name: 'version',
            title: 'Version',
            type: 'string',
        },
        {
            name: 'date',
            title: 'Date',
            type: 'date',
        },
        {
            name: 'thumb',
            title: 'Media URL',
            type: 'url',
            description: 'YouTube, Vimeo, or direct image/video URL (e.g. https://youtube.com/watch?v=xxx or https://example.com/image.jpg)'
        },
        {
            name: 'body',
            title: 'Body',
            type: 'text',
        },
    ],
}
