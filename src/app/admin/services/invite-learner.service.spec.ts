import { TestBed, inject } from '@angular/core/testing';

import { InviteLearnerService } from './invite-learner.service';

describe('InviteLearnerService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [InviteLearnerService]
    });
  });

  it('should be created', inject([InviteLearnerService], (service: InviteLearnerService) => {
    expect(service).toBeTruthy();
  }));
});
