import { describe, it, expect } from '@jest/globals';
import { VagaModel } from '../../api/models/VagaModel';

describe('VagaModel', () => {
  it('should be defined', () => {
    expect(VagaModel).toBeDefined();
  });

  it('should have required methods', () => {
    const model = new VagaModel();
    expect(typeof model.listar).toBe('function');
    expect(typeof model.buscar).toBe('function');
    expect(typeof model.criar).toBe('function');
    expect(typeof model.atualizar).toBe('function');
    expect(typeof model.excluir).toBe('function');
  });
});
