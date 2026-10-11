import { defineConfig } from 'vitepress'

const sidebar = [
  { text: 'Guide', items: [
    { text: 'Installation', link: '/guide/installation' },
    { text: 'Getting started', link: '/guide/getting-started' },
    { text: 'Choosing data', link: '/guide/data' },
    { text: 'Icons', link: '/guide/icons' },
    { text: 'Administration', link: '/guide/admin' },
  ] },
  { text: 'Reference', items: [
    { text: 'Tables and configuration', link: '/reference/tables' },
    { text: 'Addresses', link: '/reference/addresses' },
    { text: 'Currencies and MIME types', link: '/reference/utilities' },
    { text: 'Upgrading', link: '/reference/upgrading' },
  ] },
]

export default defineConfig({
  title: 'CakePHP Data',
  description: 'Reference tables, icons, currencies, addresses, and MIME types for CakePHP.',
  base: '/cakephp-data/',
  cleanUrls: true,
  lastUpdated: true,
  srcExclude: ['README.md'],
  sitemap: { hostname: 'https://dereuromark.github.io/cakephp-data/' },
  head: [['link', { rel: 'icon', href: '/cakephp-data/favicon.svg', type: 'image/svg+xml' }]],
  themeConfig: {
    logo: '/logo.svg',
    nav: [
      { text: 'Installation', link: '/guide/installation' },
      { text: 'Getting started', link: '/guide/getting-started' },
      { text: 'Reference', link: '/reference/tables' },
    ],
    sidebar,
    socialLinks: [{ icon: 'github', link: 'https://github.com/dereuromark/cakephp-data' }],
    search: { provider: 'local' },
    editLink: { pattern: 'https://github.com/dereuromark/cakephp-data/edit/master/docs/:path' },
    footer: { message: 'Released under the MIT License.', copyright: 'Copyright Mark Scherer' },
  },
})
