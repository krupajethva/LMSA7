import { TestBed, inject } from '@angular/core/testing';

import { AddressesService } from './addresses.service';

describe('AddressesService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [AddressesService]
    });
  });

  it('should be created', inject([AddressesService], (service: AddressesService) => {
    expect(service).toBeTruthy();
  }));
});
