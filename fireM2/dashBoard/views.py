from django.shortcuts import render

# Create your views here.
from events.models import *

def index(request):
    """View function for home page of site."""

    context = {
      
    }

    # Render the HTML template index.html with the data in the context variable
    return render(request, 'index.html', context=context)