import { TestBed, inject } from '@angular/core/testing';

import { ActivedeleteService } from './activedelete.service';

describe('ActivedeleteService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [ActivedeleteService]
    });
  });

  it('should be created', inject([ActivedeleteService], (service: ActivedeleteService) => {
    expect(service).toBeTruthy();
  }));
});
