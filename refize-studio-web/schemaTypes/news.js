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
            title: 'Thumbnail URL',
            type: 'url',
            description: 'Paste a full URL like https://example.com/image.jpg'
        },
        {
            name: 'body',
            title: 'Body',
            type: 'text',
        },
    ],
}
