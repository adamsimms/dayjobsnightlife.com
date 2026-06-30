/**
 * @type {import('@roots/bud').Config}
 */
export default async (app) => {
  app.extensions.add(await import('@roots/bud-sass'));

  app
    .entry('app', ['@scripts/app', '@styles/app'])
    .entry('editor', ['@scripts/editor', '@styles/editor'])
    .assets(['images']);

  app.setPublicPath('/app/themes/dayjobsnightlife/public/');

  app
    .setUrl('http://localhost:3000')
    .setProxyUrl('http://dayjobsnightlife.test')
    .watch(['resources/views', 'app']);
};
