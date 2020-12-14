export default ({app}, inject) => {
  // Inject $hello(msg) in Vue, context and store.
  inject('message', msg => M.toast({html: msg}));
  inject('error', msg => M.toast({html: `[Ошибка]: ${msg}`}));
}
