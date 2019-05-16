import { TestBed, inject } from '@angular/core/testing';

import { UserActivationService } from './user-activation.service';

describe('UserActivationService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [UserActivationService]
    });
  });

  it('should be created', inject([UserActivationService], (service: UserActivationService) => {
    expect(service).toBeTruthy();
  }));
});
