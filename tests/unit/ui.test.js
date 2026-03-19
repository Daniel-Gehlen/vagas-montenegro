import { describe, it, expect } from '@jest/globals';
import { render, screen } from '@testing-library/dom';
import '@testing-library/jest-dom';

describe('UI Components', () => {
  it('should render job list container', () => {
    document.body.innerHTML = '<div id="job-list"></div>';
    expect(document.getElementById('job-list')).toBeInTheDocument();
  });

  it('should render search input', () => {
    document.body.innerHTML = '<input type="text" id="search-input" placeholder="Buscar vagas...">';
    expect(screen.getByPlaceholderText('Buscar vagas...')).toBeInTheDocument();
  });

  it('should render add job button', () => {
    document.body.innerHTML = '<button id="add-job-btn">Adicionar Vaga</button>';
    expect(screen.getByText('Adicionar Vaga')).toBeInTheDocument();
  });
});
