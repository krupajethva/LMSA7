import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EmaillogComponent } from './emaillog.component';

describe('EmaillogComponent', () => {
  let component: EmaillogComponent;
  let fixture: ComponentFixture<EmaillogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EmaillogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EmaillogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
