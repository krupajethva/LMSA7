import { TestBed, inject } from '@angular/core/testing';

import { RegisterLearnerInvitedService } from './register-learner-invited.service';

describe('RegisterLearnerInvitedService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [RegisterLearnerInvitedService]
    });
  });

  it('should be created', inject([RegisterLearnerInvitedService], (service: RegisterLearnerInvitedService) => {
    expect(service).toBeTruthy();
  }));
});
