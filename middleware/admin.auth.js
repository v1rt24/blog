export default async ({store, redirect, $cookies}) => {
  const auth = store.getters['auth/isAuthenticated'];

  try {
    const token = $cookies.get('nuxt-auth');
    await store.dispatch('auth/watchCookie', token);
  }
  catch (error) {
    redirect('/admin/login?message=login');
  }

  if (!auth) {
    redirect('/admin/login?message=login');
  }
}
