import { TestBed, inject } from '@angular/core/testing';

import { InstructorinvitationService } from './instructorinvitation.service';

describe('InstructorinvitationService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [InstructorinvitationService]
    });
  });

  it('should be created', inject([InstructorinvitationService], (service: InstructorinvitationService) => {
    expect(service).toBeTruthy();
  }));
});
