

function courrielCOM(domaine, usager)
{ 
  c = usager + "@" + domaine + ".com"; 
  document.write("<a href='mailto:" + c + "'>" + c + "</a>");
}

function courrielORG(domaine, usager)
{ 
  c = usager + "@" + domaine + ".org"; 
  document.write("<a href='mailto:" + c + "'>" + c + "</a>");
}

function courrielNET(domaine, usager)
{ 
  c = usager + "@" + domaine + ".net"; 
  document.write("<a href='mailto:" + c + "'>" + c + "</a>");
}

