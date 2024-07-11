import { usePage } from '@inertiajs/vue3';

export function useToast() {
  const page = usePage();

  function showToast(message, type = 'info') {
    page.props.flash = { message, type };
  }


  return { showToast };
}
